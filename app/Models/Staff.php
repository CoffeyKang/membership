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
        'commission_rate',
        'bonus',
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

    public function payoutHistories()
    {
        return $this->hasMany(PayoutHistory::class);
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

    public function getTodayAmountAttribute()
    {
        return $this->transactions()->whereDate('created_at', today())->sum('amount');
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

    public function getDayoffDatesAttribute()
    {
        return $this->dayoffs()->pluck('date')->toArray();
    }

    public static function activeStaff()
    {
        return self::where('is_active', true);
    }

    public function getTotalSalesAmountAttribute()
    {
        return $this->transactions()->sum('amount');
    }

    public function getCommissionAmountAttribute()
    {   
        return $this->commission_rate * $this->total_sales_amount;
    }

    public function getTotalSalaryAttribute()
    {
       return max($this->base_salary,  $this->commission_amount) + $this->bonus;
    }

    public function payout()
    {   
        if ($this->payoutHistories()->whereDate('payout_date', today())->exists()) {
            return false;
        }
        $this->payoutHistories()->create([
            'total_amount' => $this->total_salary,
            'base_salary' => $this->base_salary,
            'sales_amount' => $this->total_sales_amount,
            'commission_amount' => $this->commission_amount,
            'number_of_transactions' => $this->number_of_working_days,
            'payout_date' => today(),
        ]);

        $this->dayoffs()->notArchived()->get()->each->archive();
        $this->transactions()->unPaid()->get()->each->payCheque();

        return true;
    }

}
