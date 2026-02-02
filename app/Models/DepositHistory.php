<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepositHistory extends Model
{
    protected $fillable = [
        'member_id',
        'amount',
        'type',
        'deposited_at',
    ];

    protected $depositTypes = [
        0 => 'messages.cash',
        1 => 'messages.alipay',
        2 => 'messages.wechat_pay',
        3 => 'messages.card_recharge',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function getTypeTextAttribute()
    {
        return __($this->depositTypes[$this->type] ?? 'messages.unknown');
    }
}
