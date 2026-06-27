<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MemberTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating Walkin Client Member Info ...');

        \App\Models\Member::create([
            'full_name' => '散客',
            'phone_number' => '0912345678',
            'balance' => 1000000,
        ]);

        $this->command->info('Walkin Client Member Created.');
    }
}
