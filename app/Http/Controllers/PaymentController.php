<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; 
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->configureMidtrans();
    }

    private function configureMidtrans()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function checkout(Request $request)
    {
        $plan = $request->query('plan');
        
        if (!in_array($plan, ['pro', 'premium'])) {
            return redirect()->route('pricing.index')->with('error', 'Paket tidak valid.');
        }

        $user = Auth::user();

        if ($user->role === 'premium') {
            return redirect()->route('pricing.index')->with('error', 'Anda sudah memiliki paket tertinggi (Premium). Downgrade tidak tersedia.');
        }

        if ($user->role === 'pro' && $plan === 'pro') {
            return redirect()->route('pricing.index')->with('error', 'Anda sudah berlangganan paket Pro.');
        }
        
        $orderId = 'SQS-' . strtoupper($plan) . '-' . time() . '-' . Str::random(5);
        
        $amount = match($plan) {
            'pro' => 100000,
            'premium' => 1,
            default => 100000
        };

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $amount,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ],
            'item_details' => [
                [
                    'id' => $plan . '_subscription',
                    'price' => $amount,
                    'quantity' => 1,
                    'name' => 'Langganan ' . ucfirst($plan) . ' SQS',
                ]
            ]
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal terhubung ke Midtrans: ' . $e->getMessage());
        }

        Transaction::create([
            'user_id' => $user->id,
            'order_id' => $orderId,
            'amount' => $amount,
            'status' => 'pending',
            'snap_token' => $snapToken,
            'metadata' => json_encode(['plan' => $plan]) 
        ]);

        return view('payment.checkout', compact('snapToken', 'amount', 'plan'));
    }

    public function success(Request $request)
    {
        return redirect()->route('dashboard')->with('status', 'Pembayaran sedang diproses. Status akan otomatis berubah dalam beberapa saat.');
    }

    public function callback(Request $request)
    {
        $this->configureMidtrans();

        try {
            $notif = new Notification();
        } catch (\Exception $e) {
            Log::error('Midtrans Notification Error: ' . $e->getMessage());
            return response()->json(['message' => 'Notification Error: ' . $e->getMessage()], 500);
        }

        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $orderId = $notif->order_id;
        $fraud = $notif->fraud_status;

        $dbTransaction = Transaction::where('order_id', $orderId)->first();

        if (!$dbTransaction) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        if ($dbTransaction->status === 'success') {
            return response()->json(['message' => 'Already processed']);
        }

        if ($transaction == 'capture') {
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    $dbTransaction->update(['status' => 'challenge']);
                } else {
                    $this->setSuccess($dbTransaction);
                }
            }
        } else if ($transaction == 'settlement') {
            $this->setSuccess($dbTransaction);
        } else if ($transaction == 'pending') {
            $dbTransaction->update(['status' => 'pending']);
        } else if ($transaction == 'deny') {
            $dbTransaction->update(['status' => 'failed']);
        } else if ($transaction == 'expire') {
            $dbTransaction->update(['status' => 'expired']);
        } else if ($transaction == 'cancel') {
            $dbTransaction->update(['status' => 'cancelled']);
        }

        return response()->json(['message' => 'Notification processed']);
    }

    private function setSuccess($transaction)
    {
        $transaction->update(['status' => 'success']);

        $metadata = $transaction->metadata;
        if (is_string($metadata)) {
            $metadata = json_decode($metadata, true);
        }
        
        $newRole = $metadata['plan'] ?? 'pro'; 

        $user = User::find($transaction->user_id);
        if ($user) {
            $user->update([
                'role' => $newRole,
                'is_premium' => true,
            ]);
        }
    }
}