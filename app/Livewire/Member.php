<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Content\Member as MemberModel;

class Member extends Component
{
    public $member;
    public $depositAmount;
    public $showDepositInput = false;
    public $depositHistories;
    public function mount($member)
    {
        $this->member = MemberModel::find($member);
        $this->depositHistories = $this->member->depositHistories()->orderBy('created_at', 'desc')->get();
    }
    public function deposit()
    {
        $this->member->balance += $this->depositAmount;
        $this->member->save();
        return redirect()->back()->with('status', 'Deposit successful!');
    }

    public function render()
    {
        return view('livewire.member-show', [
            'member' => $this->member,
            'showDepositInput' => $this->showDepositInput,
            'depositAmount' => $this->depositAmount,
            'depositHistories' => $this->depositHistories,
        ]);
    }
}
