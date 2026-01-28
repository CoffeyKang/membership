<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Transaction;
use Livewire\WithPagination;

class TransactionList extends Component
{   
    use WithPagination;

    public $transactions;

    public $period = 'today';
    public $perPage = 10;


    public function mount()
    {
        $this->getTodayTransactions();
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

        session()->flash('success', 'Transaction deleted successfully.');
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
