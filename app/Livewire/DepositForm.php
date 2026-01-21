<?php

namespace App\Livewire;

use Livewire\Component;

class DepositForm extends Component
{   
    public $member;
    public $depositAmount;
    public $type;
    public $confirmDepositAmount;

    public function mount($member)
    {
        $this->member = $member;
    }

    public function confirmDeposit()
    {
        $this->validate([
            'depositAmount' => 'required|numeric|min:100',
            'type' => 'required|in:0,1,2,3',
            'confirmDepositAmount' => 'required|same:depositAmount',
        ], [
            'depositAmount.required' => 'Please enter the deposit amount.',
            'type.required' => 'Please select the deposit type.',
            'confirmDepositAmount.required' => 'Please confirm the deposit amount.',
            'confirmDepositAmount.same' => 'The confirmed deposit amount does not match.',
        ]);

    
        $this->member->balance += $this->depositAmount;

        if ($this->depositAmount >= 1000) {
            $this->member->setPrimary();
        }
        
        $this->member->depositHistories()->create([
            'amount' => $this->depositAmount,
            'type' => $this->type,
        ]);
        $this->member->save();
        $this->dispatch('depositCompleted');

    }

    public function closeModal()
    {
        $this->dispatch('modalClosed');
    }

    public function render()
    {
        return view('livewire.deposit-form');
    }
}
