<?php

namespace App\Models\V1;

use App\Traits\ClearsResponseCache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class JobApply extends Model implements Auditable
{
    use HasFactory, ClearsResponseCache;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'talent_id',
        'job_id',
        'slug',
        'rate',
        'available_start',
        'resume',
        'other_file',
        'type',
        'status'
    ];

    public function talent()
    {
        return $this->belongsTo(Talent::class, 'talent_id');
    }

    public function talentjob()
    {
        return $this->belongsTo(TalentJob::class, 'job_id');
    }

}
