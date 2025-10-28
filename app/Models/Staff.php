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

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public static function activeStaff()
    {
        return self::where('is_active', true);
    }


}
