<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Database\Factories\TransactionFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

#[UseFactory(TransactionFactory::class)]
class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'member_id',
        'staff_id',
        'amount',
        'notes',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

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
