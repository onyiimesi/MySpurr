<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'message',
        'status'
    ];

    public function sender()
    {
        return $this->belongsTo(Talent::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(Talent::class, 'receiver_id');
    }
}
