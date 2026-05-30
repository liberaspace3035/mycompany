<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// 実績。トップの "Selected Works" と /works 一覧の両方が引く。
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('works', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('category', 64);            // 'HP制作' | 'Webシステム' | 'DX/効率化'
            $table->string('year', 8)->nullable();     // '2025' / '2024-2025'
            $table->json('tags')->nullable();          // ['Laravel', 'Three.js']
            $table->text('summary')->nullable();
            $table->string('image')->nullable();       // R2 key or absolute URL
            $table->string('url')->nullable();         // 外部リンク
            $table->boolean('featured')->default(false);  // トップに出すか
            $table->unsignedSmallInteger('position')->default(0);
            $table->timestamps();

            $table->index(['featured', 'position']);
            $table->index('category');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('works');
    }
};
