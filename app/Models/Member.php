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
    ];

    public function depositHistories()
    {
        return $this->hasMany(DepositHistory::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
