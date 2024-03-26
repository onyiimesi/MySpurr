<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class TalentJob extends Model implements Auditable
{
    use HasFactory, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'id',
        'business_id',
        'job_title',
        'slug',
        'country_id',
        'state_id',
        'job_type',
        'description',
        'responsibilities',
        'required_skills',
        'benefits',
        'salaray_type',
        'salary_min',
        'salary_max',
        'currency',
        'skills',
        'experience',
        'qualification',
        'status',
        'deleted_at',
        'is_bookmark'
    ];

    protected $casts = [
        'skills' => 'array',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function jobapply()
    {
        return $this->hasMany(JobApply::class, 'job_id');
    }

    public function bookmarkjobs()
    {
        return $this->hasMany(BookmarkJob::class, 'job_id');
    }
}
