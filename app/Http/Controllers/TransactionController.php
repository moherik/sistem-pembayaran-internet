<?php

namespace App\Http\Controllers;

use App\Models\Packet;
use App\Models\Transaction;
use Carbon\Carbon;
use Exception;
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
    public function pay($transactionId)
    {
    }
}
