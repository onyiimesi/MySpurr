<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventBrandPartner extends Model
{
    protected $table = "event_brand_partners";

    use HasFactory;

    protected $fillable = [
        'event_id',
        'image',
        'file_id'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
