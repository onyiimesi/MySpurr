<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookmarkJob extends Model
{
    use HasFactory;

    protected $fillable = [
        'talent_id',
        'job_id'
    ];

    public function talentjob()
    {
        return $this->hasMany(TalentJob::class, 'id', 'job_id');
    }
}
