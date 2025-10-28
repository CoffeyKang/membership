<?php

namespace App\Livewire;

use Livewire\Component;

class StaffList extends Component
{
    public function render()
    {
        return view('livewire.staff-list', [
            'staff' => \App\Models\Staff::all()
        ]);
    }
}
