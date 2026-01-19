<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MemberTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $members = [
            [
                'member_id' => 'M001',
                'full_name' => '散客',
                'phone_number' => '0912345678',
                'balance' => 1000000,
            ],
            [
                'member_id' => 'M002',
                'full_name' => '李四',
                'phone_number' => '0987654321',
                'balance' => 3000,
            ],
            [
                'member_id' => 'M003',
                'full_name' => '王五',
                'phone_number' => '0922333444',
                'balance' => 7000,
            ],
        ];

        foreach ($members as $member) {
            \DB::table('members')->insert($member);
        }
    }
}
