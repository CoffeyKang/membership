<?php

namespace App\Models;

use Database\Factories\MemberFactory;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[UseFactory(MemberFactory::class)]
class Member extends Model
{
    use HasFactory;

    protected $fillable = [
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

    public function memberSignatures()
    {
        return $this->hasMany(MemberSignature::class);
    }

    public function setPrimary()
    {
        $this->update(['is_primary' => true]);
    }

    public function setNormal()
    {
        $this->update(['is_primary' => false]);
    }

    /**
     * Mark the member as a walk-in client.
     *
     * @return void
     */
    public function isWalkInClient()
    {
        return $this->full_name == '散客';
    }

    /**
     * Spend money from the member's balance.
     * If the amount exceeds the current balance, no action is taken and a message is returned.
     *
     * @int int $amount
     *
     * @return string
     */
    public function spend(int $amount): void
    {
        $this->decrement('balance', $amount);
    }
}
