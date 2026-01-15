<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Staff;
use App\Models\Member;

class QuickSave extends Component
{   
    public $staff;
    public $members;
    public $selectedMemberID;
    public $memberSearch;

    public $selectedStaffId;
    public $amount;
    public $confirmAmount;
    public $notes;
    

    public function mount()
    {
        $this->staff = Staff::activeStaff()->get();
    
    }

    public function updatedMemberSearch()
    {
        $this->members = \App\Models\Member::where(function($query) {
            $query
                ->where('full_name', 'like', '%' . $this->memberSearch . '%')
                ->orWhere('member_id', 'like', '%' . $this->memberSearch . '%')
                ->orWhere('phone_number', 'like', '%' . $this->memberSearch . '%');
        })->get();
    }

    public function render()
    {
        return view('livewire.quick-save',
            [
                'staff' => $this->staff,
                'memberResults' => $this->members,
            ]
        );
    }
}
