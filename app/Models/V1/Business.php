<?php

namespace App\Models\V1;

use Illuminate\Support\Str;
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
        'email',
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
        'otp_expires_at',
        'verify_status',
        'status',
        'type',
        'terms'
    ];

    protected static function boot()
    {
        parent::boot();

        self::creating(function($model) {
            $model->uuid = (string) Str::uuid();
        });

    }
}
