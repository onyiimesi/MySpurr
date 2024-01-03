<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TalentCustomerLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'talent_id',
        'customer_id',
        'type',
        'createdAt',
        'phoneNumber',
        'email',
        'organization_id',
        'request',
        'response',
        'status'
    ];

    public function talent()
    {
        return $this->belongsTo(Talent::class);
    }
}
