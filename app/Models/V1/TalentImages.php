<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TalentImages extends Model
{
    use HasFactory;

    protected $fillable = [
        'talent_id',
        'image'
    ];

    public function talent()
    {
        return $this->belongsTo(Talent::class);
    }
}
