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
            'agent_id' => 'Admin'
        ]);
        // create member
        User::create([
            'name' => 'Member',
            'username' => 'member123',
            'password' => Hash::make('password123'),
            'role' => '1',
            'agent_id' => 'Agen_0001'
        ]);
    }
}
