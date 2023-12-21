<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TalentWallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'talent_id',
        'wallet_no',
        'current_bal',
        'previous_bal',
        'status'
    ];

    public function talent()
    {
        return $this->belongsTo(Talent::class);
    }
}
