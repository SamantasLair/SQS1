<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction as MidtransTransaction;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key') ?? env('MIDTRANS_SERVER_KEY');
        Config::$clientKey = config('midtrans.client_key') ?? env('MIDTRANS_CLIENT_KEY');
        Config::$isProduction = config('midtrans.is_production') ?? env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = config('midtrans.is_sanitized') ?? env('MIDTRANS_IS_SANITIZED', true);
        Config::$is3ds = config('midtrans.is_3ds') ?? env('MIDTRANS_IS_3DS', true);
    }

    public function checkout()
    {
        $user = Auth::user();
        
        $orderId = 'SQS-' . time() . '-' . Str::random(5);
        $amount = 50000;

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $amount,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ],
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
        ]);

        return view('payment.checkout', compact('snapToken', 'amount'));
    }

    public function success(Request $request)
    {
        $orderId = $request->query('order_id');
        
        if (!$orderId) {
            return redirect()->route('dashboard');
        }

        $transaction = Transaction::where('order_id', $orderId)->firstOrFail();

        if ($transaction->status === 'success') {
            return redirect()->route('dashboard')->with('status', 'Pembayaran Berhasil!');
        }

        try {
            $midtransStatus = MidtransTransaction::status($orderId);
            $transactionStatus = $midtransStatus->transaction_status;

            if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
                $transaction->update(['status' => 'success']);
                
                $user = User::find($transaction->user_id);
                $user->update([
                    'is_premium' => true,
                    'ai_generation_limit' => 100
                ]);

                return redirect()->route('dashboard')->with('status', 'Selamat! Akun Premium Aktif.');
            } 
            elseif ($transactionStatus == 'expire' || $transactionStatus == 'cancel' || $transactionStatus == 'deny') {
                $transaction->update(['status' => 'failed']);
                return redirect()->route('dashboard')->with('error', 'Pembayaran Gagal atau Dibatalkan.');
            }
            else {
                return redirect()->route('dashboard')->with('status', 'Pembayaran sedang diproses, silakan refresh nanti.');
            }

        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'Gagal memverifikasi status pembayaran.');
        }
    }
}