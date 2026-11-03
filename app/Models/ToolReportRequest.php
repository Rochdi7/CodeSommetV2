<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** Lead « rapport par e-mail » d'une page outil (ToolReportController). */
class ToolReportRequest extends Model
{
    protected $fillable = [
        'email',
        'name',
        'tool_slug',
        'target_url',
        'score',
        'report',
        'ip_address',
        'visitor_id',
        'analytics_session_id',
        'emailed_at',
    ];

    protected $casts = [
        'report' => 'array',
        'score' => 'integer',
        'emailed_at' => 'datetime',
    ];
}
