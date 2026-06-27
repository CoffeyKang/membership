<?php

namespace App\Livewire;

use App\Models\Member;
use App\Models\Staff;
use App\Models\Transaction;
use Livewire\Component;

class AddRecords extends Component
{
    public $staff;

    public $services = [
        '造型',
        '剪发 - 男',
        '剪发 - 女',
        '烫发',
        '染发',
        '营养',
        '产品',
    ];

    public $selectedServices = [];

    public $notes = '';

    public $amount = 0;

    public $selectedStaffId;

    public $date;

    public $selectedMemberID = 1;

    public $members;

    public $memberSearch;

    public $memberResults;

    public $walkinClientID;

    public $memberTransactions;

    public function updatedMemberSearch()
    {
        $this->memberResults = \App\Models\Member::where(function ($query) {
            $query
                ->where('full_name', 'like', '%'.$this->memberSearch.'%')
                ->orWhere('phone_number', 'like', '%'.$this->memberSearch.'%');
        })->get();
    }

    protected $rules = [
        'selectedStaffId' => 'required|exists:staff,id',
        'selectedMemberID' => 'required|exists:members,id',
        'amount' => 'required|numeric|min:0',
        'date' => 'required|date',
        'notes' => 'nullable|string|max:255',
    ];

    public function mount()
    {
        $this->staff = Staff::notLeft()->get();
        $this->members = Member::all();
        $this->selectedMemberID = Member::first()->id;
        $this->walkinClientID = Member::first()->id;
        $this->memberSearch = '';
    }

    public function addService($service)
    {
        if (in_array($service, $this->selectedServices)) {
            $this->selectedServices = array_diff($this->selectedServices, [$service]);
            $this->notes = implode(', ', $this->selectedServices);

            return;
        }

        $this->selectedServices[] = $service;

        $this->notes = implode(', ', $this->selectedServices);
    }

    public function selectClient($memberID)
    {
        $this->selectedMemberID = $memberID;
        $client = Member::find($memberID);
        $this->memberTransactions = $client->transactions()->take(5)->get();

        $this->memberSearch = $client->full_name;
        $this->memberResults =
            Member::whereIn('id', [$client->id])->get();
    }

    public function selectWalkinClient()
    {
        $this->selectedMemberID = $this->walkinClientID;
        $this->memberSearch = '';
        $this->memberTransactions = null;
    }

    public function saveQuick()
    {
        $this->validate();

        $transaction = new Transaction([
            'member_id' => $this->selectedMemberID,
            'staff_id' => $this->selectedStaffId,
            'amount' => $this->amount,
            'notes' => $this->notes.'( 补录于 '.now()->toDateString().' )',
        ]);
        $transaction->save();

        $transaction->member->balance -= $this->amount;
        $transaction->created_at = $this->date;
        $transaction->member->save();
        $transaction->save();

        $this->selectedServices = [];
        $this->selectedStaffId = null;
        $this->selectedMemberID = 1;
        $this->memberSearch = '';
        $this->amount = 0;
        $this->date = null;
        session()->flash('success', __('messages.savings_recorded_successfully'));

    }

    public function render()
    {
        return view('livewire.add-records');
    }
}
