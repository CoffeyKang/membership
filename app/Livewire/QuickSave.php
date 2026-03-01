<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Staff;
use App\Models\Member;
use App\Models\MemberSignature;

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
    public $savedSignature;
    public $signatureData = '';
    public $showMemberInfoModal = false;
    public $memberInfo = [];

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
    
    protected $listeners = [
        'saveSignature' => 'saveSignature',
    ];

    protected $rules = [
        'selectedMemberID' => 'required|exists:members,id',
        'selectedStaffId'  => 'required|exists:staff,id',
        'amount'           => 'required|numeric|min:0',
        'notes'            => 'nullable|string|max:255',
    ];

    public function mount()
    {   
        $this->members = Member::all();
        $this->staff = Staff::activeStaff()->notLeft()->get();
        $this->selectedMemberID = Member::first()->id;
        $this->walkinClientID = Member::first()->id;
    
    }

    public function updatedMemberSearch()
    {
        $this->memberResults = \App\Models\Member::where(function($query) {
            $query
                ->where('full_name', 'like', '%' . $this->memberSearch . '%')
                ->orWhere('phone_number', 'like', '%' . $this->memberSearch . '%');
        })->get();
    }

    public function saveQuick()
    {
        $this->validate();
        // Find the member by ID
        $member = Member::find($this->selectedMemberID);
        // Check if amount exceeds member balance
        if ($this->amount > $member->balance) {
            session()->flash('error', __('messages.amount_exceeds_member_balance'));
            return false;
        }
        // update member balance
        $member->spend($this->amount);
        $member->save();

        // Create or store the transaction record
        $transaction = $member->transactions()->create([
            'staff_id' => $this->selectedStaffId,
            'amount' => $this->amount,
            'notes' => $this->notes,
        ]);

        // Save signature if exists
        if ($this->savedSignature) {
            MemberSignature::create([
                'member_id' => $this->selectedMemberID,
                'transaction_id' => $transaction->id,
                'signature' => $this->savedSignature,
            ]);
        }
        
        // Reset form fields after successful save
        $this->reset(['selectedMemberID', 'selectedStaffId', 'amount', 'confirmAmount', 'notes']);

        $this->memberSearch = '';
        $this->memberResults = null;
        $this->savedSignature = null;
        session()->flash('success', __('messages.savings_recorded_successfully'));
        
        // 设置会员信息并显示弹窗
        $this->memberInfo = [
            'full_name' => $member->full_name,
            'balance' => $member->balance,
        ];
        $this->showMemberInfoModal = true;
        
        // Dispatch event to notify any necessary updates
        $this->dispatch('form-saved');
      
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

    public function saveSignature($signature)
    {
        $this->savedSignature = $signature;
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

    public function render()
    {
        return view('livewire.quick-save',
            [
                'staff' => $this->staff,
            ]
        );
    }
}
