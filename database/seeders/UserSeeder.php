<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //admin
        User::create([
            'name' => 'Admin',
            'username' => 'admin123',
            'password' => Hash::make('password123'),
            'role' => '0',
            'identity_id' => 'Admin',
            'is_active' => '1'
        ]);
        // create Reseller
        User::create([
            'name' => 'Fikri',
            'username' => 'fikri123',
            'password' => Hash::make('password123'),
            'role' => '1',
            'identity_id' => '00001',
            'is_active' => '1'
        ]);
        // create Agent
        User::create([
            'name' => 'Hanif',
            'username' => 'hanif123',
            'password' => Hash::make('password123'),
            'role' => '2',
            'identity_id' => '00002',
            'is_active' => '1'
        ]);
    }
}
