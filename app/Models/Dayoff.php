<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Database\Factories\DayoffFactory;

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
