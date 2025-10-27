<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Content\Member as MemberModel;

class Member extends Component
{
    public $member;
    public $depositAmount;

    public $showSpendModal = false;
    public $showDepositModal = false;

    protected $listeners = [
        'depositCompleted' => 'balanceUpdated',
        'modalClosed' => 'closeModals'
    ];

    public function mount($member)
    {
        $this->member = MemberModel::find($member);
    }

    public function balanceUpdated()
    {   
        session()->flash('status', 'Deposit successfully.');
        $this->showDepositModal = false;
    }

    public function closeModals()
    {
        $this->showSpendModal = false;
        $this->showDepositModal = false;
    }

    public function render()
    {
        return view('livewire.member-show', [
            'member' => $this->member,
            'depositAmount' => $this->depositAmount,
            'showSpendModal' => $this->showSpendModal,
            'showDepositModal' => $this->showDepositModal,
        ]);
    }

    
}
