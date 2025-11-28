<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
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
            'item_details' => [
                [
                    'id' => 'PREMIUM_PLAN',
                    'price' => $amount,
                    'quantity' => 1,
                    'name' => 'Upgrade SQS Premium',
                ]
            ]
        ];

        $snapToken = Snap::getSnapToken($params);

        Transaction::create([
            'user_id' => $user->id,
            'order_id' => $orderId,
            'amount' => $amount,
            'status' => 'pending',
            'snap_token' => $snapToken,
        ]);

        return view('payment.checkout', compact('snapToken', 'amount'));
    }

    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id.$request->status_code.$request->gross_amount.$serverKey);

        if ($hashed == $request->signature_key) {
            $transaction = Transaction::where('order_id', $request->order_id)->first();
            
            if (!$transaction) return response()->json(['message' => 'Transaction not found'], 404);

            if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                $transaction->update(['status' => 'success']);

                $user = User::find($transaction->user_id);
                $user->update([
                    'is_premium' => true,
                    'ai_generation_limit' => 100, 
                ]);

            } elseif ($request->transaction_status == 'expire' || $request->transaction_status == 'cancel' || $request->transaction_status == 'deny') {
                $transaction->update(['status' => 'failed']);
            }
        }

        return response()->json(['status' => 'OK']);
    }
}