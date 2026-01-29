<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   
        DB::table('users')->truncate();
        
        // Create admin user
        \App\Models\User::create([
            'name' => '人民发艺管理员',
            'email' => 'admin@rmfy.cn',
            'email_verified_at' => now(),
            'is_admin' => true,
            'password' => bcrypt('230116'),
        ]);

        \App\Models\User::create([
            'name' => '人民发艺',
            'email' => 'user@rmfy.cn',
            'email_verified_at' => now(),
            'is_admin' => false,
            'password' => bcrypt('88888888'),
        ]);

        $this->command->info('Users Created.');
    }
}
