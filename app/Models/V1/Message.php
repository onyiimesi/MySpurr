<?php

namespace App\Models\V1;

use App\Models\Admin\Admin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

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
        'status'
    ];

    protected $casts = [
        'attachment' => 'array'
    ];

    public function getHasRepliedAttribute()
    {
        return $this->messageReply()->count() > 0;
    }

    // public function sender()
    // {
    //     if ($this->sender_type === 'App\Models\V1\Business') {
    //         return $this->belongsTo(Business::class, 'sender_id');
    //     } elseif ($this->sender_type === 'App\Models\V1\Talent') {
    //         return $this->belongsTo(Talent::class, 'sender_id');
    //     } else {
    //         return $this->belongsTo(Admin::class, 'sender_id');
    //     }
    // }

    public function sender()
    {
        return $this->morphTo();
    }

    // public function receiver()
    // {
    //     if ($this->receiver_type === 'App\Models\V1\Business') {
    //         return $this->belongsTo(Business::class, 'receiver_id');
    //     } elseif ($this->receiver_type === 'App\Models\V1\Talent') {
    //         return $this->belongsTo(Talent::class, 'receiver_id');
    //     } else {
    //         return $this->belongsTo(Admin::class, 'receiver_id');
    //     }
    // }

    public function receiver()
    {
        return $this->morphTo();
    }

    public function messageReply()
    {
        return $this->hasMany(MessageReply::class, 'message_id');
    }
}
