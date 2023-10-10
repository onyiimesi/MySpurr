<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TalentEducation extends Model
{
    use HasFactory;

    protected $fillable = [
        'talent_id',
        'school_name',
        'degree',
        'field_of_study',
        'start_date',
        'end_date',
        'description'
    ];

    public function talent()
    {
        $this->belongsTo(Talent::class);
    }
}
