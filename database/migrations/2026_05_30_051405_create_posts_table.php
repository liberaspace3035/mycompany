<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// ブログ記事。本文は Markdown を保存、表示時に league/commonmark でレンダ。
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->text('summary')->nullable();
            $table->longText('body_md');                       // Markdown 原文
            $table->string('eyecatch')->nullable();            // R2 key
            $table->boolean('featured')->default(false);
            $table->timestamp('published_at')->nullable();     // null = 下書き
            $table->timestamps();

            $table->index(['published_at', 'featured']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
