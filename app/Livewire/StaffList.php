<?php

namespace App\Livewire;

use Livewire\Component;

class StaffList extends Component
{
    public $staff;

    public function mount()
    {
        $this->staff = \App\Models\Staff::notLeft()->get();
    }

    public function createStaff()
    {
        return $this->redirectRoute('staff.create');
    }

    public function render()
    {
        return view('livewire.staff-list');
    }
}
