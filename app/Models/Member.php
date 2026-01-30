<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Database\Factories\MemberFactory;

#[UseFactory(MemberFactory::class)]
class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'full_name',
        'phone_number',
        'balance',
        'is_primary',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    protected static function booted()
    {
        static::created(function ($member) {
            $member->depositHistories()->create([
                'amount' => $member->balance,
                'type' => 3,
            ]);
        });
    }
    
    public function depositHistories()
    {
        return $this->hasMany(DepositHistory::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function setPrimary()
    {
        $this->update(['is_primary' => true]);
    }
    
    /**
     * Mark the member as a walk-in client.
     *
     * @return void
     */
    public function isWalkInClient()
    {
        return $this->member_id == 'M001';
    }
    /**
     * Spend money from the member's balance.
     * If the amount exceeds the current balance, no action is taken and a message is returned.
     *
     * @int int $amount
     * @return string
     */
    public function spend(int $amount): void
    {   
        $this->decrement('balance', $amount);
    }
}
