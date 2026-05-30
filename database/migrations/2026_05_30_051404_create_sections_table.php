<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// ページ内ブロック。
// type で「at_a_glance / services_grid / ai_dev / principles / how / works_picks / why / cta / manifest」
// などを切り替え、Blade 側で `@includeFirst("sections.{$type}", ...)` のように呼び分ける。
// 個別のフィールドが多種多様なので、payload を JSON にして型を吸収。
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->constrained()->cascadeOnDelete();
            $table->string('type', 64);          // ex: 'at_a_glance', 'services_grid'
            $table->string('heading')->nullable();
            $table->string('subheading')->nullable();
            $table->json('payload')->nullable();
            $table->unsignedSmallInteger('position')->default(0);
            $table->boolean('visible')->default(true);
            $table->timestamps();

            $table->index(['page_id', 'position']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};
