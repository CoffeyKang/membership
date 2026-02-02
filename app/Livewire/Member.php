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
        'modalClosed' => 'closeModals',
        'depositHistoryDeleted' => 'depositHistoryDeleted',
    ];

    public function mount(MemberModel $member)
    {
        $this->member = $member;
    }

    public function balanceUpdated()
    {   
        session()->flash('status', __('messages.deposit_successfully'));
        $this->showDepositModal = false;
    }

    public function spendCompleted()
    {
        session()->flash('status', __('messages.spend_successfully'));
        $this->showSpendModal = false;
    }

    public function depositHistoryDeleted()
    {   
        $this->member = MemberModel::find($this->member->id);
        session()->flash('status', __('messages.deposit_history_deleted'));
    }

    public function memberInfoChanged()
    {
        session()->flash('status', __('messages.member_info_updated'));
    }

    public function closeModals()
    {
        $this->showSpendModal = false;
        $this->showDepositModal = false;
    }

    public function memberUpdated()
    {
        session()->flash('status', __('messages.member_updated_successfully')); 
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
