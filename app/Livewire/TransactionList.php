<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Staff;
use App\Models\Transaction;
use Livewire\WithPagination;

class TransactionList extends Component
{   
    use WithPagination;

    public $transactions;

    public $period = 'today';
    public $perPage = 10;
    public $selectedDate;
    public $selectedStaffId;

    public $staff;


    public function mount()
    {
        $this->getTodayTransactions();
        $this->selectedDate = date('Y-m-d');
        $this->staff = Staff::notLeft()->get();
    }

    public function deleteTransaction($id)
    {   
        $transaction = Transaction::find($id);
        if ( !$transaction) {
            session()->flash('error', 'Transaction not found.');
            return false;
        }
        $member = $transaction->member;
        // update member balance
        if (!$member) {
            session()->flash('error', 'Member not found.');
            return false;
        }
        $member->update(['balance' => $member->balance + $transaction->amount]);
        $member->save();
        // delete transaction
        $transaction->delete();

        $this->getTodayTransactions();

        session()->flash('success', __('messages.transaction_deleted'));
    }

    public function getALlTransactions()
    {
        $this->transactions = Transaction::query()
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    public function getTodayTransactions()
    {
        $this->transactions = Transaction::setPeriod('today')
            ->setStaffId($this->selectedStaffId)
            ->orderBy('created_at', 'desc')
            ->get();

        $this->selectedDate = date('Y-m-d');
    }
    public function getYesterdayTransactions()
    {
        $this->transactions = Transaction::setPeriod('yesterday')
            ->setStaffId($this->selectedStaffId)
            ->orderBy('created_at', 'desc')
            ->get();
        
        $this->selectedDate = date('Y-m-d', strtotime('-1 day'));
    }

    public function filterByDatePicker()
    {
        $this->transactions = Transaction::whereDate('created_at', $this->selectedDate)
            ->setStaffId($this->selectedStaffId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function setStaffFilter($staffId)
    {
        $this->selectedStaffId = $staffId;
        
        $this->transactions = Transaction::whereDate('created_at', $this->selectedDate)
            ->setStaffId($this->selectedStaffId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function render()
    {
        return view('livewire.transaction-list', [
            'transactions' => $this->transactions,
        ]);
    }
}
