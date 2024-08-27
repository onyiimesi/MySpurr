<?php

namespace App\Models\V1;

use App\Notifications\V1\ResetPasswordNotification;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;

class Business extends Authenticatable implements Auditable
{
    use HasFactory, SoftDeletes, HasApiTokens, Notifiable;
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
        'country_code',
        'facebook',
        'twitter',
        'instagram',
        'behance',
        'size',
        'linkedin',
    ];

    protected $casts = [
        'industry' => 'array'
    ];

    protected $with = ['talentjobtypes'];

    protected static function boot()
    {
        parent::boot();

        self::creating(function($model) {
            $model->uuid = (string) Str::uuid();
        });

        static::deleting(function ($model) {
            $model->talentjob()->delete();
        });

    }

    public function sendPasswordResetNotification($token): void
    {
        $email = $this->email;

        $url = config('services.reset_password_url').'?token='.$token.'&email='.$email;

        $this->notify(new ResetPasswordNotification($url));
    }

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

    public function talentjobtypes()
    {
        return $this->hasMany(TalentJobType::class, 'business_id');
    }
}
