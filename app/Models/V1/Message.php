<?php

namespace App\Models\V1;

use App\Traits\ClearsResponseCache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory, ClearsResponseCache;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'sender_type',
        'receiver_type',
        'send_to',
        'subject',
        'body',
        'cc',
        'bcc',
        'attachment',
        'is_draft',
        'is_sent',
        'sent_at',
        'status',
        'broad_cast_message_id',
        'type',
    ];

    protected $casts = [
        'attachment' => 'array'
    ];

    public function getHasRepliedAttribute()
    {
        return $this->messageReply()->count() > 0;
    }

    public function sender()
    {
        return $this->morphTo();
    }

    public function receiver()
    {
        return $this->morphTo();
    }

    public function messageReply()
    {
        return $this->hasMany(MessageReply::class, 'message_id');
    }

    public function broadCastMessages()
    {
        return $this->hasMany(BroadCastMessage::class, 'broad_cast_message_id');
    }
}
