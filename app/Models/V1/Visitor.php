<?php

namespace App\Models\V1;

use App\Traits\ClearsResponseCache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory, ClearsResponseCache;

    protected $fillable = [
        'ip_address',
        'country',
        'user_agent'
    ];
}
