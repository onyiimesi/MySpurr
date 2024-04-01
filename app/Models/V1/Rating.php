<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'talent_id',
        'rated_by',
        'rating',
        'talent_job_id'
    ];

    public function business()
    {
        return $this->belongsTo(Business::class, 'rated_by');
    }
}
