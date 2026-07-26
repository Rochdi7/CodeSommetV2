<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuoteRequest extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'project_type',
        'budget',
        'timeline',
        'details',
        'payload',
        'source',
        'ip_address',
        'user_agent',
        'status',
    ];

    protected $casts = [
        'payload' => 'array',
    ];
}
