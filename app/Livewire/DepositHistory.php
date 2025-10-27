<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Reactive;

class DepositHistory extends Component
{   
    #[Reactive]
    public $member;

    public function render()
    {
        return view('livewire.deposit-history', [
            'depositHistories' => $this->member->depositHistories()->orderBy('created_at', 'desc')->get() ,
        ]);
    }
}
