<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// company.html の Skills セクション。カテゴリでグルーピング表示。
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->string('category', 64);             // 'Frontend' | 'Backend' | 'AI' | 'Infra'
            $table->string('name');                     // 'Laravel' / 'Three.js' / ...
            $table->unsignedTinyInteger('level')->default(80);  // 0-100 (バー表示用)
            $table->unsignedSmallInteger('position')->default(0);
            $table->timestamps();

            $table->index(['category', 'position']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skills');
    }
};
