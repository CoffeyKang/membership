<?php

namespace App\Livewire;

use Livewire\Component;

class Staff extends Component
{   
    public $staff;
    

    public function toggleActive()
    {   
        $today  = now()->format('Y-m-d');

        $this->staff->is_active = !$this->staff->is_active;
        if( !$this->staff->is_active ) {
            $this->staff->dayoffs()->create([
                'date' => $today,
            ]);
        } else {
            $this->staff->dayoffs()
                ->where('date', $today)
                ->where('staff_id', $this->staff->id)
                ->delete();
        }

        $this->staff->save();
    }
        
    public function render()
    {
        return view('livewire.staff', [
            'staff' => $this->staff,
        ]);
    }
}
