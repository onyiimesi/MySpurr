<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Question extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['job_id', 'question'];

    public function talentjob()
    {
        return $this->belongsTo(TalentJob::class);
    }

    public function answers()
    {
        return $this->hasMany(QuestionAnswer::class);
    }
}
