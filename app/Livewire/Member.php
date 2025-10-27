<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Content\Member as MemberModel;

class Member extends Component
{
    public $member;

    public function mount($member)
    {
        $this->member = MemberModel::find($member);
    }

    public function deposit($amount)
    {   
        $this->member->balance += $amount; 
        $this->member->save();
        return redirect()->back()->with('status', 'Deposit successful!');
    }

    public function render()
    {
        return view('livewire.member-show', [
            'member' => $this->member,
        ]);
    }
}
