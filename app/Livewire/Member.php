<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Member as MemberModel;

class Member extends Component
{
    public $member;
    public $depositAmount;

    public $showSpendModal = false;
    public $showDepositModal = false;

    protected $listeners = [
        'depositCompleted' => 'balanceUpdated',
        'spendCompleted' => 'spendCompleted',
        'modalClosed' => 'closeModals'
    ];

    public function mount(MemberModel $member)
    {
        $this->member = $member;
    }

    public function balanceUpdated()
    {   
        session()->flash('status', 'Deposit successfully.');
        $this->showDepositModal = false;
    }

    public function spendCompleted()
    {
        session()->flash('status', 'Spend successfully. Welcome back!');
        $this->showSpendModal = false;
    }

    public function memberInfoChanged()
    {
        session()->flash('status', 'Member info has been updated!');
    }

    public function closeModals()
    {
        $this->showSpendModal = false;
        $this->showDepositModal = false;
    }

    public function memberUpdated()
    {
        session()->flash('status', 'Member updated successfully.');
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
