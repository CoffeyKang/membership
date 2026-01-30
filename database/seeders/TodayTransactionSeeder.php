<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TodayTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch existing staff and member IDs
        $staffIds = \App\Models\Staff::pluck('id')->toArray();
        $memberIds = \App\Models\Member::pluck('id')->toArray();

        // Ensure we have staff and members to work with
        if (empty($staffIds) || empty($memberIds)) {
            return;
        }

        // Create 20 transactions
        for ($i = 0; $i < 20; $i++) {
            \App\Models\Transaction::create([
                'staff_id'   => $staffIds[array_rand($staffIds)],
                'member_id'  => $memberIds[array_rand($memberIds)],
                'amount'     => rand(1000, 50000) / 100, // Random amount between 10.00 and 500.00
                'notes'      => 'Transaction ' . ($i + 1), // Optional note
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
