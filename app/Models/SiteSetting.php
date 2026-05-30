<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'site_name', 'contact_email', 'nav_items',
        'footer_tagline', 'footer_columns', 'payload',
    ];

    protected $casts = [
        'nav_items' => 'array',
        'footer_columns' => 'array',
        'payload' => 'array',
    ];

    // シングルトンとしての取得。なければ作る。
    public static function current(): self
    {
        return static::firstOrCreate(['id' => 1], [
            'site_name' => 'Liberaspace',
        ]);
    }
}
