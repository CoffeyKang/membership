<?php

namespace App\Livewire;

use App\Models\Staff;
use Livewire\Component;

class StaffPayout extends Component
{
    public Staff $staff;

    public $fromDate;

    public $tillDate;

    public $totalAmount;

    public $commissionAmount;

    public function mount(Staff $staff)
    {
        $this->staff = $staff;
        $this->fromDate = date('Y-m-d', strtotime($this->staff->transactions()->unPaid()->min('created_at') ?? today()));
        $this->tillDate = date('Y-m-d');
        $this->totalAmount = $this->staff->transactions()->unPaid()->setDateRange($this->fromDate, $this->tillDate)->sum('amount');
        $this->commissionAmount = $this->staff->commission_rate * $this->totalAmount;
    }

    public function updatedFromDate()
    {
        $this->totalAmount = $this->staff->transactions()->unPaid()->setDateRange($this->fromDate, $this->tillDate)->sum('amount');
        $this->commissionAmount = $this->staff->commission_rate * $this->totalAmount;
    }

    public function updatedTillDate()
    {
        $this->totalAmount = $this->staff->transactions()->unPaid()->setDateRange($this->fromDate, $this->tillDate)->sum('amount');
        $this->commissionAmount = $this->staff->commission_rate * $this->totalAmount;
    }

    public function payout()
    {
        if (! $this->staff->payout($this->fromDate, $this->tillDate)) {
            session()->flash('fail', __('messages.payout_failed'));

            return;
        }
        session()->flash('success', __('messages.payout_processed_successfully'));
    }

    public function render()
    {
        return view('livewire.staff-payout', [
            'staff' => $this->staff,
        ]);
    }
}
