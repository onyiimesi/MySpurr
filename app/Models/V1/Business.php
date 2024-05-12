<?php

namespace App\Models\V1;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;

class Business extends Authenticatable implements Auditable
{
    use HasFactory, SoftDeletes, HasApiTokens;
    use \OwenIt\Auditing\Auditable;

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
        'terms',
        'ciso',
        'siso',
        'longitude',
        'latitude',
        'phone_number',
        'country_code'
    ];

    protected static function boot()
    {
        parent::boot();

        self::creating(function($model) {
            $model->uuid = (string) Str::uuid();
        });

    }

    protected $casts = [
        'industry' => 'array'
    ];

    public function talentjob()
    {
        return $this->hasMany(TalentJob::class, 'business_id');
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id')->where('sender_type', 'App\Models\V1\Business');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id')->where('receiver_type', 'App\Models\V1\Business');
    }
}
