<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    protected $fillable = [
        'slug', 'title', 'category', 'year', 'tags',
        'summary', 'image', 'url', 'featured', 'position',
    ];

    protected $casts = [
        'tags' => 'array',
        'featured' => 'boolean',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopeFeatured(Builder $q): Builder
    {
        return $q->where('featured', true)->orderBy('position');
    }
}
