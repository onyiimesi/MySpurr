<?php

namespace App\Models\Admin;

use App\Models\V1\RegisteredEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'speaker_bio',
        'speaker',
        'speaker_title',
        'event_time',
        'event_date',
        'event_link',
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

    public function eventBrandPartners(): HasMany
    {
        return $this->hasMany(EventBrandPartner::class, 'event_id');
    }

    public function registeredEvents(): HasMany
    {
        return $this->hasMany(RegisteredEvent::class, 'event_id');
    }
}
