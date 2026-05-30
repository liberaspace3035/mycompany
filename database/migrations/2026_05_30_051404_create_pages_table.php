<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// 各ページ (index/services/works/blog/company) のメタ + Hero。
// セクション本体は sections テーブル側で持つ。
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();                 // 'home' | 'services' | 'works' | 'blog' | 'company'
            $table->string('name');
            $table->string('hero_eyebrow')->nullable();       // 例: "SYS // RENDERING"
            $table->string('hero_title');
            $table->text('hero_sub')->nullable();
            $table->string('hero_jp_tagline')->nullable();    // 「創ることを、もっと身近に。」
            $table->json('hero_meta')->nullable();            // データリードアウト [{label, value}]
            $table->string('cta_label')->nullable();
            $table->string('cta_url')->nullable();
            $table->string('secondary_cta_label')->nullable();
            $table->string('secondary_cta_url')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
