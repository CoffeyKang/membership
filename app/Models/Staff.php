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
        return $this->transactions()->unpaid()->sum('amount');
    }

    public function getTodayAmountAttribute()
    {
        return $this->transactions()->whereDate('created_at', today())->sum('amount');
    }

    public function getNumberOfWorkingDaysAttribute()
    {
        return count($this->getWorkingDates());
    }

    public function getNumberOfDayoffsAttribute()
    {
        return count($this->getDayoffs());
    }

    public function getDayoffDatesAttribute()
    {
        return array_unique($this->dayoffs()->pluck('date')->toArray());
    }

    public static function activeStaff()
    {
        return self::where('is_active', true);
    }

    public function getTotalSalesAmount($fromDate, $tillDate)
    {
        return $this->transactions()->setDateRange($fromDate, $tillDate)->sum('amount');
    }

    public function getCommissionAmount($fromDate, $tillDate)
    {
        return $this->commission_rate * $this->getTotalSalesAmount($fromDate, $tillDate);
    }

    public function getTotalSalaryAttribute()
    {
        return max($this->base_salary, $this->commission_amount) + $this->bonus;
    }

    public function payout($fromDate, $tillDate)
    {
        if ($this->payoutHistories()->whereDate('payout_date', today())->exists() && $this->getTotalSalesAmount($fromDate, $tillDate) == 0) {
            return false;
        }
        $this->payoutHistories()->create([
            'total_amount' => $this->total_salary,
            'base_salary' => $this->base_salary,
            'sales_amount' => $this->getTotalSalesAmount($fromDate, $tillDate),
            'commission_amount' => $this->getCommissionAmount($fromDate, $tillDate),
            'number_of_transactions' => $this->number_of_working_days,
            'from_date' => $fromDate,
            'till_date' => $tillDate,
            'payout_date' => today(),
        ]);

        $this->dayoffs()->notArchived()->get()->each->archive();
        $this->transactions()->unPaid()->setDateRange($fromDate, $tillDate)->get()->each->payCheque();

        return true;
    }

    public function getWorkingDates()
    {
        $working_days = [];
        foreach ($this->transactions()->get() as $work_day) {
            $working_days[] = $work_day->created_at->format('Y-m-d');
        }

        return array_unique($working_days);
    }

    public function getDayoffs()
    {
        $working_dates = $this->getWorkingDates();

        if (empty($working_dates)) {
            return [];
        }

        $startDate = \Carbon\Carbon::parse(min($working_dates));
        $endDate = \Carbon\Carbon::today();
        $allDates = [];
        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $allDates[] = $date->format('Y-m-d');
        }

        return array_diff($allDates, $working_dates);
    }
}
