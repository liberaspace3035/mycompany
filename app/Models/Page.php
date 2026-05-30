<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Page extends Model
{
    protected $fillable = [
        'slug', 'name', 'hero_eyebrow', 'hero_title', 'hero_sub',
        'hero_jp_tagline', 'hero_meta',
        'cta_label', 'cta_url', 'secondary_cta_label', 'secondary_cta_url',
        'meta_description', 'meta_keywords',
    ];

    protected $casts = [
        'hero_meta' => 'array',
    ];

    public function sections(): HasMany
    {
        return $this->hasMany(Section::class)->orderBy('position');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
