<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayoutHistory extends Model
{
    protected $fillable = [
        'staff_id',
        'total_amount',
        'sales_amount',
        'commission_amount',
        'number_of_transactions',
        'payout_date',
    ];

    protected $casts = [
        'payout_date' => 'date',
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    protected static function booted()
    {
        static::addGlobalScope('order', function ($query) {
            $query->orderByDesc('created_at');
        });
    }
}
