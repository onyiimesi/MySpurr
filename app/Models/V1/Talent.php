<?php

namespace App\Models\V1;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\V1\ResetPasswordNotification;


class Talent extends Authenticatable
{
    use HasFactory, SoftDeletes, HasApiTokens, Notifiable;

    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'email',
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
        'otp_expires_at',
        'verify_status',
        'status',
        'type',
        'availability'
    ];

    protected static function boot()
    {
        parent::boot();

        self::creating(function($model) {
            $model->uuid = (string) Str::uuid();
        });

    }

    public function topskills()
    {
        return $this->hasMany(TopSkill::class);
    }

    public function talentimage()
    {
        return $this->hasMany(TalentImages::class);
    }

    public function bankAccount()
    {
        return $this->hasMany(BankAccount::class);
    }

    public function educations()
    {
        return $this->hasMany(TalentEducation::class, 'talent_id');
    }

    public function employments()
    {
        return $this->hasMany(TalentEmployment::class, 'talent_id');
    }

    public function certificates()
    {
        return $this->hasMany(TalentCertificate::class, 'talent_id');
    }


    public function sendPasswordResetNotification($token): void
    {
        $url = 'https://mango-glacier-097715310.3.azurestaticapps.net/reset-password?token='.$token;

        $this->notify(new ResetPasswordNotification($url));
    }
}
