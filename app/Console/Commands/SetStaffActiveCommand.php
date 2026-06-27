<?php

namespace App\Console\Commands;

use App\Models\Staff;
use Illuminate\Console\Command; // Using the Staff model to update staff status

class SetStaffActiveCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'set:staff-active';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set all staff status to active';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Setting all staff status to active...');

        // Update all staff members to active status
        // Set is_active to true for all staff who haven't left (is_left = false)
        $updatedCount = Staff::update(['is_active' => true]);

        $this->info("Successfully updated {$updatedCount} staff member(s) to active status.");

        return 0;
    }
}
