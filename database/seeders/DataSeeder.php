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
            'name' => 'User',
            'username' => 'user',
            'email' => 'user@mail.com',
            'password' => 'user',
            'phone' => '230284208230',
            'gender' => 'MALE',
            'address' => 'IND',
            'role' => 'USER',
        ]);

    }
}
