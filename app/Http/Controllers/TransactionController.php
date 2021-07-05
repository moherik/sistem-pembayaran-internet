<?php

namespace App\Http\Controllers;

use App\Models\Packet;
use App\Models\Transaction;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\HttpException;

class TransactionController extends Controller
{

    public function history()
    {
        $userId = Auth::user()->id;
        $transactions = Transaction::where('user_id', $userId)->with('packet')->where('status', 'SUCCESS')->orderBy('created_at', 'DESC')->get();
        return response()->json($transactions, 200);
    }

    public function totalPayment()
    {
        $myTrx = Transaction::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->first();
        return response()->json([
            'orderId' => $myTrx->order_id,
            'unpaid' => $myTrx->total_price,
            'payDate' => $myTrx->pay_date,
        ], 200);
    }

    public function check()
    {
        $trx = Auth::user()->transaction()->orderBy('created_at', 'DESC')->first();
        return response()->json($trx);
    }

    public function buy($packetId)
    {
        $user = Auth::user();
        if ($user->has_active_packet) {
            return response()->json([
                'code' => 400,
                'status' => 'ERROR',
                'message' => 'Akun sudah punya paket aktif'
            ], 400);
        }

        try {
            $packet = Packet::where('id', $packetId)->firstOrFail();
            $now = Carbon::now();
            Transaction::create([
                'user_id' => $user->id,
                'packet_id' => $packet->id,
                'total_price' => $packet->price,
                'pay_date' => ($packet->type == 'MONTHLY') ? $now->addMonth() : $now->addYear()
            ]);
            return response()->json([
                'code' => 200,
                'status' => 'SUCCESS',
                'message' => 'Berhasil melakukan transaksi'
            ], 200);
        } catch (HttpException $e) {
            return response()->json([
                'code' => $e->getCode(),
                'status' => 'ERROR',
                'message' => $e->getMessage()
            ], $e->getStatusCode());
        }
    }

    public function pay($orderId)
    {
        try {
            $user = Auth::user();

            \Midtrans\Config::$serverKey = 'SB-Mid-server-eTSr0VeD0QjZWQ1IHdWp_qTY';
            \Midtrans\Config::$isProduction = false;
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            $trx = $user->transaction()->where(['trx_code' => $orderId])->first();

            $params = array(
                'transaction_details' => array(
                    'order_id' => $trx->trx_code,
                    'gross_amount' => $trx->total_price,
                ),
                'customer_details' => array(
                    'first_name' => $trx->name,
                    'email' => $trx->email,
                    'phone' => $trx->phone,
                ),
            );

            $snapUrl = \Midtrans\Snap::getSnapUrl($params);

            return response()->json(['url' => $snapUrl]);
        } catch (HttpException $e) {
            return response()->json([
                'code' => $e->getCode(),
                'status' => 'ERROR',
                'message' => $e->getMessage()
            ], $e->getStatusCode());
        }
    }

    public function payFinish(Request $request)
    {
        echo 'Selesaikan Pembayaran, anda bisa menutup browser ini.';
    }

    public function handleMidtransHook()
    {
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$serverKey = 'SB-Mid-server-eTSr0VeD0QjZWQ1IHdWp_qTY';
        $notif = new \Midtrans\Notification();

        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $order_id = $notif->order_id;
        $fraud = $notif->fraud_status;

        if ($transaction == 'capture') {
            // For credit card transaction, we need to check whether transaction is challenge by FDS or not
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    // TODO set payment status in merchant's database to 'Challenge by FDS'
                    // TODO merchant should decide whether this transaction is authorized or not in MAP
                    echo "Transaction order_id: " . $order_id . " is challenged by FDS";
                } else {
                    // TODO set payment status in merchant's database to 'Success'
                    Transaction::where(['trx_code' => $order_id])->update(['status' => 'SUCCESS']);
                    echo "Transaction order_id: " . $order_id . " successfully captured using " . $type;
                }
            }
        } else if ($transaction == 'settlement') {
            // TODO set payment status in merchant's database to 'Settlement'
            Transaction::where(['trx_code' => $order_id])->update(['status' => 'SUCCESS']);
            echo "Transaction order_id: " . $order_id . " successfully transfered using " . $type;
        } else if ($transaction == 'pending') {
            // TODO set payment status in merchant's database to 'Pending'
            Transaction::where(['trx_code' => $order_id])->update(['status' => 'WAITING']);
            echo "Waiting customer to finish transaction order_id: " . $order_id . " using " . $type;
        } else if ($transaction == 'deny') {
            // TODO set payment status in merchant's database to 'Denied'
            Transaction::where(['trx_code' => $order_id])->update(['status' => 'CANCEL']);
            echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is denied.";
        } else if ($transaction == 'expire') {
            // TODO set payment status in merchant's database to 'expire'
            Transaction::where(['trx_code' => $order_id])->update(['status' => 'CANCEL']);
            echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is expired.";
        } else if ($transaction == 'cancel') {
            // TODO set payment status in merchant's database to 'Denied'
            Transaction::where(['trx_code' => $order_id])->update(['status' => 'CANCEL']);
            echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is canceled.";
        }
    }
}
