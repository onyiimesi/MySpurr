<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'business_id',
        'job_title',
        'location',
        'skills',
        'rate',
        'commitment',
        'job_type',
        'capacity',
        'status'
    ];

    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id');
    }
}
