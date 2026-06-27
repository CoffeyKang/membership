<?php

namespace App\Livewire;

use App\Models\Member;
use Livewire\Component;

class SignaturePad extends Component
{
    public $memberId;

    public $signatureData = '';

    public $savedSignature = '';

    public function mount(int $memberId)
    {
        $this->memberId = $memberId;
    }

    public function saveSignature()
    {
        // 验证签名数据是否存在
        if (empty($this->signatureData)) {
            return;
        }
        $member = Member::find($this->memberId);

        // 验证会员是否存在
        if (! $member) {
            session()->flash('error', '会员不存在！');

            return;
        }

        $transaction_id = $member->transactions()->latest()->first()?->id;

        // 验证交易是否存在
        if (! $transaction_id) {
            session()->flash('error', '会员最近一次交易不存在！');

            return;
        }

        $this->dispatch('saveSignature', $this->signatureData);

        $this->savedSignature = $this->signatureData;

        session()->flash('message', '签名已保存成功！');
    }

    public function render()
    {
        return view('livewire.signature-pad');
    }
}
