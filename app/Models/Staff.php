<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $fillable = [
        'nick_name',
        'full_name',
        'phone_number',
        'base_salary',
        'monthly_minimum_sales_amount',
        'commission_rate',
        'is_active',
        'is_left',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_left' => 'boolean',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function scopeIsLeft($query)
    {
        return $query->where('is_left', true);
    }

    public function scopeNotLeft($query)
    {
        return $query->where('is_left', false);
    }

    public static function activeStaff()
    {
        return self::where('is_active', true);
    }


}
