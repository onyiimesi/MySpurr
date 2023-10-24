<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TalentEmployment extends Model
{
    use HasFactory;

    protected $fillable = [
        'talent_id',
        'company_name',
        'title',
        'employment_type',
        'start_date',
        'end_date',
        'description',
        'currently_working_here'
    ];

    public function talent()
    {
        $this->belongsTo(Talent::class);
    }
}
