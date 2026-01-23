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

    public function dayoffs()
    {
        return $this->hasMany(Dayoff::class);
    }

    public function scopeIsLeft($query)
    {
        return $query->where('is_left', true);
    }

    public function scopeNotLeft($query)
    {
        return $query->where('is_left', false);
    }

    public function getUnpaidAmountAttribute()
    {
        return $this->transactions()->sum('amount');
    }

    public function getNumberOfWorkingDaysAttribute()
    {   
        $working_days = [];
        foreach ($this->transactions()->get() as $work_day) {
            $working_days[] = $work_day->created_at->format('Y-m-d');
        }
        $working_days = array_unique($working_days);
        return count($working_days);
    }

    public function getNumberOfDayoffsAttribute()
    {
        return $this->dayoffs()->count();
    }

    public static function activeStaff()
    {
        return self::where('is_active', true);
    }

    public function payCheque()
    {
        $this->dayoffs()->notArchived()->get()->each->archive();
        $this->transactions()->unPaid()->get()->each->payCheque();
    }


}
