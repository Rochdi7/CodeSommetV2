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
        'visitor_id',
        'analytics_session_id',
        'status',
    ];

    protected $casts = [
        'payload' => 'array',
    ];
}
