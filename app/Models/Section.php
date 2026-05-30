<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Section extends Model
{
    protected $fillable = [
        'page_id', 'type', 'heading', 'subheading',
        'payload', 'position', 'visible',
    ];

    protected $casts = [
        'payload' => 'array',
        'visible' => 'boolean',
    ];

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    // payload からドット記法で値を引く糖衣
    public function get(string $key, mixed $default = null): mixed
    {
        return data_get($this->payload ?? [], $key, $default);
    }
}
