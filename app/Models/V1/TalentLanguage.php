<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TalentLanguage extends Model
{
    use HasFactory;

    protected $fillable = [
        'talent_id',
        'language',
        'proficiency'
    ];
}
