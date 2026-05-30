<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// サイト全体のシングルトン設定。1行だけ存在する想定。
// 細かい設定が増えても json カラムで拡張できるよう、payload も持たせる。
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name')->default('Liberaspace');
            $table->string('contact_email')->nullable();
            $table->json('nav_items')->nullable();   // [{label, url}]
            $table->string('footer_tagline')->nullable();
            $table->json('footer_columns')->nullable();
            $table->json('payload')->nullable();     // future-proof bag
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
