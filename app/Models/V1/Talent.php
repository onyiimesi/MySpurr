<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Talent extends Authenticatable
{
    use HasFactory, SoftDeletes, HasApiTokens;

    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'email_address',
        'skill_title',
        'top_skills',
        'highest_education',
        'year_obtained',
        'work_history',
        'certificate_earned',
        'compensation',
        'portfolio_title',
        'portfolio_description',
        'image',
        'social_media_link',
        'password',
        'otp',
        'verify_status',
        'status',
        'hear_about_us',
        'availability'
    ];
}
