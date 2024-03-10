<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::insert([
            [
                'name' => 'Ranjith',
                'email' => 'ranjith@sumanastech.com',
                'password' => Hash::make('ranjith@123'),
                'type' => 'admin'
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@sumanastech.com',
                'password' => Hash::make('admin@123'),
                'type' => 'admin'
            ],
            [
                'name' => 'User 1',
                'email' => 'user1@sumanastech.com',
                'password' => Hash::make('user1@123'),
                'type' => 'user'
            ],
            [
                'name' => 'User 2',
                'email' => 'user2@sumanastech.com',
                'password' => Hash::make('user2@123'),
                'type' => 'user'
            ]
        ]);
    }
}
