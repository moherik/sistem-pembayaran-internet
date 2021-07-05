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
        $myTrx = Transaction::where('user_id', Auth::user()->id);
        $unpaid = $myTrx->where('status', 'PENDING')->sum('total_price') ?? 9;
        $payDate = $myTrx->orderBy('created_at', 'DESC')->first()->pay_date ?? null;
        return response()->json([
            'unpaid' => $unpaid,
            'payDate' => $payDate,
        ], 200);
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

    public function pay()
    {
        try {
            $user = Auth::user();

            \Midtrans\Config::$serverKey = 'SB-Mid-server-eTSr0VeD0QjZWQ1IHdWp_qTY';
            \Midtrans\Config::$isProduction = false;
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;
            
            $params = array(
                'transaction_details' => array(
                    'order_id' => $user->transaction->trx_code,
                    'gross_amount' => $user->transaction->total_price,
                ),
                'customer_details' => array(
                    'first_name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                ),
            );
                
            $snapUrl = \Midtrans\Snap::getSnapUrl($params);
    
            return response()->json(['token' => $snapUrl]);                
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
        $orderId = $request->get('order_id');
        $trxStatus = $request->get('transaction_status');
        Transaction::where('trx_code', $orderId)->update(['status' => 'WAITING']);
    }
}
