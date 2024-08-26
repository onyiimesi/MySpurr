<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CountryTwo extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'iso2',
        'iso3'
    ];
}
