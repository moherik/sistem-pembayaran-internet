<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Developer',
            'username' => 'dev',
            'email' => 'dev@mail.com',
            'password' => Hash::make('dev'),
            'role' => 'ADMIN',
        ]);
    }
}
