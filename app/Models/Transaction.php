<?php

namespace App\Models;

use Database\Factories\TransactionFactory;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[UseFactory(TransactionFactory::class)]
class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'member_id',
        'staff_id',
        'amount',
        'balance',
        'notes',
        'is_paid',
        'paid_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    protected $periods = ['today', 'yesterday', 'this_month', 'this_year', 'all'];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function memberSignature()
    {
        return $this->hasMany(MemberSignature::class);
    }

    public function scopeWalkIn($query)
    {
        return $query->where('member_id', 1);
    }

    public function scopeSetPeriod($query, $period)
    {
        if (! in_array($period, $this->periods)) {
            throw new \InvalidArgumentException('Invalid period. Allowed periods are: '.implode(', ', $this->periods));
        }

        return $query->where(function ($q) use ($period) {
            switch ($period) {
                case 'today':
                    $q->whereDate('created_at', today());
                    break;
                case 'yesterday':
                    $q->whereDate('created_at', \Carbon\Carbon::yesterday());
                    break;
                case 'this_month':
                    $q->whereMonth('created_at', now()->month)
                        ->whereYear('created_at', now()->year);
                    break;
                case 'this_year':
                    $q->whereYear('created_at', now()->year);
                    break;
                case 'all':
                    // No additional conditions needed for 'all'
                    break;
            }
        });

    }

    public function scopeSetDateRange($query, $fromDate, $tillDate)
    {
        return $query->whereBetween('created_at', [$fromDate, $tillDate]);
    }

    public function scopeSetStaffId($query, $staffId)
    {
        if ($staffId == null) {
            return $query;
        }

        return $query->where('staff_id', $staffId);
    }

    public function payCheque()
    {
        $this->update(['is_paid' => true, 'paid_at' => now()]);
    }

    public function scopeUnPaid($query)
    {
        return $query->where('is_paid', false);
    }

    public static function todayTransactions()
    {
        return self::setPeriod('today')->sum('amount');
    }

    public static function todayMemberTransactionTotal()
    {
        return self::setPeriod('today')->where('member_id', '!=', 1)->sum('amount');
    }

    public static function todayWalkInTransactionTotal()
    {
        return self::walkIn()->setPeriod('today')->sum('amount');
    }

    protected static function booted()
    {
        static::addGlobalScope('order', function ($query) {
            $query->orderByDesc('created_at');
        });

        static::deleted(function ($transaction) {
            $transaction->memberSignature()->delete();
        });
    }
}
