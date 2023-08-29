<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Business extends Authenticatable
{
    use HasFactory, SoftDeletes, HasApiTokens;

    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'email_address',
        'business_name',
        'location',
        'industry',
        'about_business',
        'website',
        'business_service',
        'business_email',
        'company_logo',
        'company_type',
        'social_media',
        'social_media_two',
        'password',
        'otp',
        'verify_status',
        'status',
        'type',
        'terms'
    ];

    
}
