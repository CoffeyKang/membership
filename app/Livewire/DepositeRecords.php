<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\DepositHistory;

class DepositeRecords extends Component
{   
    public $depositHistories;
    public $fromDate;
    public $tillDate;
    public $totalAmount;

    public function mount()
    {   
        $this->fromDate = date('Y-m-01');
        $this->tillDate = date('Y-m-d');
        $this->depositHistories = DepositHistory::setDateRange($this->fromDate, $this->tillDate)->orderBy('created_at', 'desc')->get();
        $this->totalAmount = $this->depositHistories->sum('amount');
    }
    
    public function updatedFromDate()
    {
        $this->depositHistories = DepositHistory::setDateRange($this->fromDate, $this->tillDate)->orderBy('created_at', 'desc')->get();
        $this->totalAmount = $this->depositHistories->sum('amount');
    }

    public function updatedTillDate()
    {
        $this->depositHistories = DepositHistory::setDateRange($this->fromDate, $this->tillDate)->orderBy('created_at', 'desc')->get();
        $this->totalAmount = $this->depositHistories->sum('amount');
    }

    public function filterByDateRange()
    {
        $this->depositHistories = DepositHistory::setDateRange($this->fromDate, $this->tillDate)->orderBy('created_at', 'desc')->get();
        $this->totalAmount = $this->depositHistories->sum('amount');
    }


    public function render()
    {
        return view('livewire.deposite-records');
    }
}
