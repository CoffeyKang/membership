<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StaffTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating Boss Info ...');
        
        \App\Models\Staff::create([
            'nick_name' => '大侠',
            'full_name' => '郭霞',
            'phone_number' => '13478211060',
            'base_salary' => 3500,
            'commission_rate' => 0.4,
            'is_active' => true,
            'is_left' => false,
            'created_at' => now(),
        ]);

        $this->command->info('The Boss Created.');
    }
}
