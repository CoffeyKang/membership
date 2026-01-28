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
            session()->flash('fail', 'Payout failed.');
            return;
        }
        session()->flash('success', 'Payout processed successfully.');
    }

    public function render()
    {
        return view('livewire.staff-payout', [
            'staff' => $this->staff,
        ]);
    }
}
