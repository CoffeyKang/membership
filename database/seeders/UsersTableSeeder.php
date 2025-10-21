<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => '人民发艺管理员',
            'email' => 'admin@renmin.com',
            'email_verified_at' => now(),
            'is_admin' => true,
            'password' => bcrypt('896365'),
        ]);

        \App\Models\User::create([
            'name' => '人民发艺',
            'email' => 'user@renmin.com',
            'email_verified_at' => now(),
            'is_admin' => false,
            'password' => bcrypt('88888888'),
        ]);
    }
}
