<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageReply extends Model
{
    use HasFactory;

    protected $fillable = [
        'message_id',
        'sender_id',
        'receiver_id',
        'sender_type',
        'receiver_type',
        'message',
        'attachment',
        'replied_at',
        'status'
    ];

    protected $casts = [
        'attachment' => 'array'
    ];

    public function sender()
    {
        if ($this->sender_type === 'App\Models\V1\Business') {
            return $this->belongsTo(Business::class, 'sender_id');
        } else {
            return $this->belongsTo(Talent::class, 'sender_id');
        }
    }

    public function receiver()
    {
        if ($this->receiver_type === 'App\Models\V1\Business') {
            return $this->belongsTo(Business::class, 'receiver_id');
        } else {
            return $this->belongsTo(Talent::class, 'receiver_id');
        }
    }

    public function message()
    {
        return $this->belongsTo(Message::class, 'message_id');
    }
}
