<?php

namespace App\Http\Controllers;

use App\Models\Packet;

class PacketController extends Controller
{

    public function getAll()
    {
        $packets = Packet::where('deleted_at', null)->orderBy('created_at', 'DESC')->get();
        return response()->json($packets, 200);
    }

    public function feed()
    {
        $packets = Packet::where('deleted_at', null)->orderBy('created_at', 'DESC')->limit(3)->get();
        return response()->json($packets, 200);
    }
}
