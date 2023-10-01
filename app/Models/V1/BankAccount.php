<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'talent_id',
        'account_number',
        'bank_name',
        'account_name',
        'pin',
        'otp',
        'otp_expires_at',
        'status'
    ];

    public function talent()
    {
        return $this->belongsTo(Talent::class);
    }
}
