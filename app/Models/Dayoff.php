<?php

namespace App\Models;

use Database\Factories\DayoffFactory;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[UseFactory(DayoffFactory::class)]
class Dayoff extends Model
{
    use HasFactory;

    protected $fillable = [
        'staff_id',
        'date',
        'is_archived',
    ];

    protected $casts = [
        'is_archived' => 'boolean',
    ];

    public function scopeNotArchived($query)
    {
        return $query->where('is_archived', false);
    }

    public function archive()
    {
        $this->update(['is_archived' => true]);
    }

    protected static function booted()
    {
        static::addGlobalScope('notArchived', function ($builder) {
            $builder->where('is_archived', false);
        });
    }
}
