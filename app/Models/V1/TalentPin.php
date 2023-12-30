<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TalentPin extends Model
{
    use HasFactory;

    protected $fillable = [
        'talent_id',
        'pin_hash',
        'expires_at',
        'attempts',
        'ip_address',
        'device_info'
    ];

    public function talent()
    {
        return $this->belongsTo(Talent::class);
    }
}
