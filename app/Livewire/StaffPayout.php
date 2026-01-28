<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Staff;


class StaffPayout extends Component
{   
    public Staff $staff;

    public function mount(Staff $staff)
    {   
        $this->staff = $staff;
    }

    public function payout()
    {
        if( !$this->staff->payout()) {
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
