<?php

namespace App\Livewire;

use App\Models\Staff;
use App\Models\Transaction;
use Livewire\Component;

class StaffManagement extends Component
{
    public $staff;

    public $todayTransactions;

    public $todayWalkInTransactions;

    public $todayMemberTransactions;

    public function mount()
    {
        $this->staff = Staff::all();
        $this->todayTransactions = Transaction::todayTransactions();
        $this->todayWalkInTransactions = Transaction::todayWalkInTransactionTotal();
        $this->todayMemberTransactions = Transaction::todayMemberTransactionTotal();
    }

    public function payCheque($staffId)
    {
        $staff = Staff::findOrFail($staffId);
        $staff->payCheque();
    }

    public function render()
    {
        return view('livewire.staff-management');
    }
}
