<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TalentJobType extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'type',
        'attempt',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class, 'business_id');
    }
}
