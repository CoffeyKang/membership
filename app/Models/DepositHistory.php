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
        0 => '现金',
        1 => '支付宝',
        2 => '微信',
        3 => '老账本余额',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function getTypeTextAttribute()
    {
        return $this->depositTypes[$this->type] ?? '未知';
    }
}
