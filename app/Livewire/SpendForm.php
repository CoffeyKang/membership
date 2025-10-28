<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Staff;

class SpendForm extends Component
{   
    public $member;
    public $staff;
    public $spendAmount;
    public $confirmSpendAmount;
    public $notes;
    public $selectedStaff;

    public function mount($member)
    {
        $this->member = $member;
        $this->staff = Staff::activeStaff()->get();
    }

    public function confirmSpend()
    {
        // Validate spend amount
        $this->validate([
            'spendAmount' => 'required|numeric|min:10|max:' . $this->member->balance,
            'confirmSpendAmount' => 'required|same:spendAmount',
            'selectedStaff' => 'required|exists:staff,id',
            'notes' => 'nullable|string|max:255',
        ]);

        // Deduct amount from member's balance
        $this->member->balance -= $this->spendAmount;
        $this->member->save();

        // Optionally, create a transaction record here

        $this->member->transactions()->create([
            'staff_id' => $this->selectedStaff,
            'amount' => $this->spendAmount,
            'notes' => $this->notes,
        ]);

        // Notify parent component about the update
        $this->dispatch('spendCompleted');

        // Close the modal
        $this->closeModal();
    }
    public function closeModal()
    {
        $this->dispatch('modalClosed');
    }

    public function render()
    {
        return view('livewire.spend-form',[
            'member' => $this->member,
            'staff' => $this->staff,
            'spendAmount' => $this->spendAmount,
        ]);
    }
}
