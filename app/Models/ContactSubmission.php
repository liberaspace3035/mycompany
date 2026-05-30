<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactSubmission extends Model
{
    protected $fillable = [
        'name', 'email', 'company', 'body',
        'source_url', 'referrer', 'user_agent', 'ip', 'read',
    ];

    protected $casts = [
        'read' => 'boolean',
    ];
}
