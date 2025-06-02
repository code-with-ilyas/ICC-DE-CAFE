<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Zahid',
            'email' => 'net3zahid@gmail.com',
            'password' => bcrypt('azad123@'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Client',
            'email' => 'net3client@gmail.com',
            'password' => bcrypt('client0506'),
            'role' => 'client',
        ]);
    }
}
