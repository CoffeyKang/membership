<?php

namespace App\Livewire;

use Livewire\Component;

class Staff extends Component
{   
    public $staff;
    

    public function toggleActive()
    {
        $this->staff->is_active = !$this->staff->is_active;
        $this->staff->save();
    }
        
    public function render()
    {
        return view('livewire.staff', [
            'staff' => $this->staff,
        ]);
    }
}
