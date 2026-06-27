<?php

namespace App\Livewire;

use App\Models\Member;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class DepositHistory extends Component
{
    #[Reactive]
    public $member;

    public function deleteDeposit($id)
    {
        $history = $this->member->depositHistories()->find($id);
        if (! $history) {
            return $this->dispatch('showError', message: __('messages.deposit_history_not_found'));
        }

        // 更新成员的余额 - 先从数据库重新获取实例以避免reactive prop错误
        $member = Member::find($this->member->id);
        $member->balance -= $history->amount;
        $member->save();

        $history->delete();
        session()->flash('success', __('messages.deposit_history_deleted'));
        // 刷新成员实例以更新余额
        $this->dispatch('depositHistoryDeleted');

    }

    public function render()
    {
        return view('livewire.deposit-history', [
            'depositHistories' => $this->member->depositHistories()->orderBy('created_at', 'desc')->paginate(4),
        ]);
    }
}
