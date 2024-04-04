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
use OwenIt\Auditing\Contracts\Auditable;


class Talent extends Authenticatable implements Auditable
{
    use HasFactory, SoftDeletes, HasApiTokens, Notifiable;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'email',
        'skill_title',
        'overview',
        'location',
        'employment_type',
        'top_skills',
        'highest_education',
        'rate',
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
        'availability',
        'linkedin',
        'instagram',
        'twitter',
        'behance',
        'facebook',
        'application_link',
        'currency',
        'phone_number',
        'country_code',
        'country',
        'ciso',
        'state',
        'siso',
        'longitude',
        'latitude',
        'experience_level',
        'booking_link'
    ];

    protected static function boot()
    {
        parent::boot();

        self::creating(function($model) {
            $model->uuid = (string) Str::uuid();
        });

        static::deleting(function ($model) {
            $model->topskills()->delete();
            $model->talentimage()->delete();
            $model->educations()->delete();
            $model->employments()->delete();
            $model->certificates()->delete();
            $model->portfolios()->delete();
            $model->talentbillingaddress()->delete();
            $model->talentlanguage()->delete();
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

    public function portfolios()
    {
        return $this->hasMany(TalentPortfolio::class, 'talent_id');
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id')->where('sender_type', 'App\Models\V1\Talent');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id')->where('receiver_type', 'App\Models\V1\Talent');
    }

    public function talentbillingaddress()
    {
        return $this->hasOne(TalentBillingAddress::class, 'talent_id');
    }

    public function talentlanguage()
    {
        return $this->hasMany(TalentLanguage::class, 'talent_id');
    }

    public function talentidentity()
    {
        return $this->hasOne(TalentIdentity::class, 'talent_id');
    }

    public function talentwallet()
    {
        return $this->hasOne(TalentWallet::class, 'talent_id');
    }

    public function openticket()
    {
        return $this->hasMany(OpenTicket::class, 'talent_id');
    }

    public function talentpin()
    {
        return $this->hasOne(TalentPin::class, 'talent_id');
    }

    public function talentcustomerlog()
    {
        return $this->hasOne(TalentCustomerLog::class, 'talent_id');
    }

    public function jobapply()
    {
        return $this->hasMany(JobApply::class, 'talent_id');
    }

    public function sendPasswordResetNotification($token): void
    {
        $url = 'https://www.app.myspurr.net/rest-password?token='.$token;

        $this->notify(new ResetPasswordNotification($url));
    }

    public function ratingsGiven()
    {
        return $this->hasMany(Rating::class, 'rated_by');
    }

    public function ratingsReceived()
    {
        return $this->hasMany(Rating::class, 'talent_id');
    }
}
