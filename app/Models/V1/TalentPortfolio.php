<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class TalentPortfolio extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'talent_id',
        'title',
        'client_name',
        'job_type',
        'location',
        'max_rate',
        'min_rate',
        'tags',
        'cover_image',
        'body'
    ];

    public function talent()
    {
        $this->belongsTo(Talent::class);
    }
}
