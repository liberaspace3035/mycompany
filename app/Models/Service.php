<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'slug', 'name', 'eyebrow', 'summary',
        'features', 'pricing', 'keywords', 'position',
    ];

    protected $casts = [
        'features' => 'array',
        'pricing' => 'array',
        'keywords' => 'array',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
