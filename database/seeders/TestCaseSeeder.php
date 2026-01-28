<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Member;
use App\Models\Staff;
use App\Models\Transaction;
use App\Models\Dayoff;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class TestCaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('zh_CN');

        $this->command->info('Creating test data...');

        // Clear existing data to avoid duplicates
        DB::table('transactions')->truncate();
        DB::table('dayoffs')->truncate();
        DB::table('members')->truncate();
        DB::table('staff')->truncate();

        // Create test members (50 members)
        $this->command->info('Creating 50 members...');
        
        $members = [];
        for ($i = 0; $i < 50; $i++) {
            $members[] = [
                'full_name' => $faker->firstName . ' ' . $faker->lastName,
                'phone_number' => $faker->numerify('1##########'), // Chinese-style phone number
                'member_id' => 'M' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                'balance' => $faker->numberBetween(0, 5000),
                'is_primary' => $faker->boolean(70), // 70% chance of being primary
                'created_at' => $faker->dateTimeBetween('-2 years', 'now'),
                'updated_at' => $faker->dateTimeBetween('-2 years', 'now'),
            ];
        }
        
        // Insert members in chunks to avoid memory issues
        foreach (array_chunk($members, 100) as $chunk) {
            DB::table('members')->insert($chunk);
        }

        $this->command->info('Created 50 members.');

        // Create test staff (4 staff members)
        $this->command->info('Creating 4 staff members...');
        
        $staffs = [];
        for ($i = 0; $i < 4; $i++) {
            $staffs[] = [
                'full_name' => $faker->firstName . ' ' . $faker->lastName,
                'nick_name' => $faker->firstName,
                'phone_number' => $faker->numerify('1##########'), // Chinese-style phone number
                'base_salary' => $faker->numberBetween(3000, 8000),
                'monthly_minimum_sales_amount' => $faker->numberBetween(5000, 15000),
                'commission_rate' => $faker->randomElement([0.05, 0.08, 0.10, 0.12, 0.15]),
                'is_left' => $faker->boolean(10), // 10% chance of leaving
                'created_at' => $faker->dateTimeBetween('-2 years', 'now'),
                'updated_at' => $faker->dateTimeBetween('-2 years', 'now'),
            ];
        }
        
        foreach (array_chunk($staffs, 100) as $chunk) {
            DB::table('staff')->insert($chunk);
        }

        $this->command->info('Created 4 staff members.');

        // Get the IDs after inserting
        $memberIds = DB::table('members')->pluck('id')->toArray();
        $staffIds = DB::table('staff')->pluck('id')->toArray();

        // Create test transactions (300 transactions)
        $this->command->info('Creating 300 transactions...');
        
        $transactions = [];
        for ($i = 0; $i < 300; $i++) {
            $transactions[] = [
                'member_id' => $faker->randomElement($memberIds),
                'staff_id' => $faker->randomElement($staffIds),
                'amount' => $faker->numberBetween(50, 500),
                'notes' => $faker->sentence(),
                'is_paid' => $faker->boolean(85), // 85% chance of being paid
                'created_at' => $faker->dateTimeBetween('2025-09-01', 'now'),
                'updated_at' => $faker->dateTimeBetween('2025-09-01', 'now'),
            ];
        }
        
        foreach (array_chunk($transactions, 100) as $chunk) {
            DB::table('transactions')->insert($chunk);
        }

        $this->command->info('Created 300 transactions.');

        // Create test dayoffs (100 dayoffs)
        $this->command->info('Creating 100 dayoffs...');
        
        $dayoffs = [];
        for ($i = 0; $i < 100; $i++) {
            $dayoffs[] = [
                'staff_id' => $faker->randomElement($staffIds),
                'date' => $faker->dateTimeBetween('2025-09-01', '+1 month')->format('Y-m-d'),
                'is_archived' => $faker->boolean(20), // 20% chance of being archived
                'created_at' => $faker->dateTimeBetween('2025-09-01', 'now'),
                'updated_at' => $faker->dateTimeBetween('2025-09-01', 'now'),
            ];
        }
        
        foreach (array_chunk($dayoffs, 100) as $chunk) {
            DB::table('dayoffs')->insert($chunk);
        }

        $this->command->info('Created 100 dayoffs.');

        $this->command->info('Test data seeding completed successfully!');
        $this->command->info('Summary:');
        $this->command->info('- 50 Members created');
        $this->command->info('- 4 Staff members created');
        $this->command->info('- 300 Transactions created');
        $this->command->info('- 100 Dayoffs created');
    }
}