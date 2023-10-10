<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Job extends Model implements Auditable
{
    use HasFactory, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

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

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

}
