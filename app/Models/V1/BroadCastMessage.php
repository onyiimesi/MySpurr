<?php

namespace App\Models\V1;

use App\Models\User;
use App\Traits\ClearsResponseCache;
use Illuminate\Database\Eloquent\Model;

class BroadCastMessage extends Model
{
    use ClearsResponseCache;

    protected $fillable = [
        'sender_id',
        'subject',
        'brand',
        'message',
        'type',
        'status',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }
}
