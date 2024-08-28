<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'amount',
        'vat',
        'reference',
        'channel',
        'currency',
        'ip_address',
        'paid_at',
        'createdAt',
        'transaction_date',
        'status',
        'name'
    ];
}
