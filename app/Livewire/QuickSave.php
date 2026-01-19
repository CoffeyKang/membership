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
    public $memberResults;
    public $walkinClientID;
    public $memberTransactions;

    public $selectedStaffId;
    public $amount;
    public $confirmAmount;
    public $notes;
    

    public function mount()
    {   
        $this->members = Member::all();
        $this->staff = Staff::activeStaff()->get();
        $this->selectedMemberID = Member::where('member_id', 'M001')->first()->id;
        $this->walkinClientID = Member::where('member_id', 'M001')->first()->id;
    
    }

    public function updatedMemberSearch()
    {
        $this->memberResults = \App\Models\Member::where(function($query) {
            $query
                ->where('full_name', 'like', '%' . $this->memberSearch . '%')
                ->orWhere('member_id', 'like', '%' . $this->memberSearch . '%')
                ->orWhere('phone_number', 'like', '%' . $this->memberSearch . '%');
        })->get();
    }

    public function saveQuick()
    {
        // Validate required fields
        $this->validate([
            'selectedMemberID' => 'required|exists:members,id',
            'selectedStaffId'  => 'required|exists:staff,id',
            'amount'           => 'required|numeric|min:0',
            'confirmAmount'    => 'required|same:amount',
            'notes'            => 'nullable|string|max:255',
        ]);
        // Find the member by ID
        $member = Member::find($this->selectedMemberID);

        // Check if amount exceeds member balance
        if ($this->amount > $member->balance) {
            session()->flash('error', 'Amount exceeds member balance.');
            return false;
        }
        // update member balance
        $member->spend($this->amount);
        $member->save();

        // Create or store the transaction record
        $member->transactions()->create([
            'staff_id' => $this->selectedStaffId,
            'amount' => $this->amount,
            'notes' => $this->notes,
        ]);

        
        // Reset form fields after successful save
        $this->reset(['selectedMemberID', 'selectedStaffId', 'amount', 'confirmAmount', 'notes']);
        
        session()->flash('success', 'Savings recorded successfully!');
    }

    public function selectClient($memberID)
    {
        $this->selectedMemberID = $memberID;
        $client = Member::find($memberID);
        $this->memberTransactions = $client->transactions()->take(3)->get();
    }


    public function render()
    {
        return view('livewire.quick-save',
            [
                'staff' => $this->staff,
            ]
        );
    }
}
