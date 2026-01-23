<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Staff;

class StaffManagement extends Component
{   
    public $staff;

    public function mount()
    {   
        $this->staff = Staff::all();
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
