<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Staff;

class StaffTransactions extends Component
{   
    use WithPagination;

    public Staff $staff;
    public $transactions;
    public $perPage = 7;
    public $period = 'this_month';

    public function mount(Staff $staff)
    {
        $this->staff = $staff;
    }


    public function getStaffTransactionsProperty()
    {   
        return $this->staff->transactions()
            ->setPeriod($this->period)
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);
    }

    public function totalTransactions()
    {
        return $this->staff->transactions()->setPeriod($this->period)->count();
    }

    public function totalAmount()
    {
        return $this->staff->transactions()->setPeriod($this->period)->sum('amount');
    }

    public function setPeriod($period)
    {
        $this->period = $period;
    }

    public function render()
    {
        return view('livewire.staff-transactions');
    }
}
