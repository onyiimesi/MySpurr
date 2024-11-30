<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ExternalJob extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'company_name',
        'location',
        'job_type',
        'description',
        'responsibilities',
        'required_skills',
        'salary',
        'link',
        'status',
    ];
}
