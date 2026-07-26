<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'budget',
        'inquiry_type',
        'message',
        'source',
        'ip_address',
        'user_agent',
        'status',
    ];
}
