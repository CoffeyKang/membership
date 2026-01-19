<?php

namespace App\Livewire;

use Livewire\Component;

class MemberForm extends Component
{   
    public $member;
    public $name;
    public $email;
    public $phone;

    public function mount($member)
    {
        $this->member = $member;
    }

    public function submit()
    {
        // Handle form submission logic here
    }

    public function createMember()
    {
        return 123;
    }


    public function render()
    {
        return view('livewire.member-form');
    }
}
