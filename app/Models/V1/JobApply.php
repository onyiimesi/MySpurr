<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApply extends Model
{
    use HasFactory;

    protected $fillable = [
        'talent_id',
        'job_id',
        'rate',
        'available_start',
        'resume',
        'other_file',
    ];

}
