<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'speaker_bio',
        'speaker',
        'event_time',
        'event_date',
        'timezone',
        'address',
        'linkedln',
        'content',
        'tags',
        'featured_speaker',
        'file_id',
        'featured_graphics',
        'featured_graphic_file_id',
        'publish_date',
        'is_published',
        'status'
    ];

    public function eventBrandPartners()
    {
        return $this->hasMany(EventBrandPartner::class, 'event_id');
    }
}
