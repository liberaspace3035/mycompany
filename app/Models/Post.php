<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use League\CommonMark\GithubFlavoredMarkdownConverter;

class Post extends Model
{
    protected $fillable = [
        'slug', 'title', 'category_id', 'summary', 'body_md',
        'eyecatch', 'featured', 'published_at',
    ];

    protected $casts = [
        'featured' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopePublished(Builder $q): Builder
    {
        return $q->whereNotNull('published_at')->where('published_at', '<=', now());
    }

    // 表示用。league/commonmark がない環境では nl2br にフォールバック。
    public function getBodyHtmlAttribute(): string
    {
        if (! class_exists(GithubFlavoredMarkdownConverter::class)) {
            return nl2br(e($this->body_md ?? ''));
        }
        $converter = new GithubFlavoredMarkdownConverter([
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);
        return (string) $converter->convert($this->body_md ?? '');
    }
}
