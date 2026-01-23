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
        $staffs = [
            [
                'nick_name' => '小明',
                'full_name' => '王小明',
                'phone_number' => '13800138000',
                'base_salary' => 4000,
                'monthly_minimum_sales_amount' => 12000,
                'commission_rate' => 0.5,
                'is_active' => true,
                'is_left' => false,
                'created_at' => now(),
            ],
            [
                'nick_name' => '小李',
                'full_name' => '李小红',
                'phone_number' => '13800138001',
                'base_salary' => 3500,
                'monthly_minimum_sales_amount' => 10000,
                'commission_rate' => 0.4,
                'is_active' => true,
                'is_left' => false,
                'created_at' => now(),      
            ],
            [
                'nick_name' => '阿强',
                'full_name' => '张强',
                'phone_number' => '13800138002',
                'base_salary' => 3000,
                'monthly_minimum_sales_amount' => 8000,
                'commission_rate' => 0.3,
                'is_active' => false,
                'is_left' => true,
                'created_at' => now(),      
            ],
        ];

        foreach ($staffs as $staff) {
            \DB::table('staff')->insert($staff);
        }
    }
}
