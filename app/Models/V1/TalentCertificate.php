<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class TalentCertificate extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

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
