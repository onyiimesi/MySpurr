<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpenTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'talent_id',
        'name',
        'email',
        'subject',
        'department',
        'priority',
        'zip',
        'message',
        'attachment',
        'status'
    ];

    public function talent()
    {
        return $this->belongsTo(Talent::class);
    }
}
