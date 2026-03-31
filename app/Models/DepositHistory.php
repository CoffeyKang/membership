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
        3 => 'messages.open_card',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function scopeNotWalkinClient($query)
    {
        return $query->where('member_id', '!=', 1);
    }

    public function getTypeTextAttribute()
    {
        return __($this->depositTypes[$this->type] ?? 'messages.unknown');
    }

    public function scopeSetDateRange($query, $fromDate, $tillDate)
    {
        return $query->whereBetween('created_at', [$fromDate, $tillDate]);
    }

    protected static function booted()
    {
        static::addGlobalScope('notWalkinClient', function ($query) {
            $query->where('member_id', '!=', 1);
        });
    }
}
