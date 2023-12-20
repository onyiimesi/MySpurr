<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TalentIdentity extends Model
{
    use HasFactory;

    protected $fillable = [
        'talent_id',
        'country',
        'document_type',
        'front',
        'back',
        'confirm',
        'status'
    ];

    public function talent()
    {
        return $this->belongsTo(Talent::class);
    }
}
