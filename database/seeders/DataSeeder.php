<?php

namespace Database\Seeders;

use App\Models\Packet;
use App\Models\Ticket;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;

class DataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Erik Mabengga',
            'username' => 'mabengga',
            'email' => 'muherik.maulana@gmail.com',
            'password' => Hash::make('mabengga'),
            'phone' => '230284208230',
            'gender' => 'MALE',
            'addess' => 'IND',
            'role' => 'USER',
        ]);

        $packet = Packet::create([
            'name' => 'Paket Ketengan',
            'price' => 200000,
            'speed' => 20,
            'description' => 'deskripsi',
            'type' => 'MONTHLY'
        ]);

        $trx = Transaction::create([
            'user_id' => $user->id,
            'packet_id' => $packet->id,
            'total_item' => 1,
            'total_price' => $packet->price,
            'pay_date' => now(),
        ]);

        $ticket = Ticket::create([
            'user_id' => $user->id,
            'title' => 'Halo Dunia'
        ]);
    }
}
