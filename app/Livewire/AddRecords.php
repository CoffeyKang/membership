<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Staff;
use App\Models\Transaction;

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

    protected $rules = [
        'selectedStaffId'  => 'required|exists:staff,id',
        'amount'           => 'required|numeric|min:0',
        'date'             => 'required|date',
        'notes'            => 'nullable|string|max:255',
    ];

    public function mount()
    {
        $this->staff = Staff::notLeft()->get();
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

    public function saveQuick()
    {
        $this->validate();

        $transaction = new Transaction([
            'member_id' => 1,
            'staff_id' => $this->selectedStaffId,
            'amount' => $this->amount,
            'notes' => $this->notes . "( 补录于 " . now()->toDateString() . ' )',
        ]);
        $transaction->save();

        $transaction->member->balance -= $this->amount;
        $transaction->created_at = $this->date;
        $transaction->member->save();
        $transaction->save();


        $this->selectedServices = [];
        $this->selectedStaffId = null;
        $this->amount = 0;
        $this->date = null;
        session()->flash('success', __('messages.savings_recorded_successfully'));
        
    }
    public function render()
    {
        return view('livewire.add-records');
    }
}
