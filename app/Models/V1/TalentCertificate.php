<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TalentCertificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'talent_id',
        'title',
        'institute',
        'certificate_date',
        'certificate_year',
        'certificate_link',
        'currently_working_here'
    ];

    public function talent()
    {
        $this->belongsTo(Talent::class);
    }
}
