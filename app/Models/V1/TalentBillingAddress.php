<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TalentBillingAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'talent_id',
        'country',
        'state',
        'address_1',
        'address_2',
        'city',
        'zip_code'
    ];
}
