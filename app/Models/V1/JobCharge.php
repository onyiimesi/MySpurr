<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Model;

class JobCharge extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'percentage',
        'status'
    ];
}
