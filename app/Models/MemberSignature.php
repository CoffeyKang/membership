<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberSignature extends Model
{
    protected $table = 'member_signatures';

    protected $fillable = [
        'member_id',
        'transaction_id',
        'signature',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
