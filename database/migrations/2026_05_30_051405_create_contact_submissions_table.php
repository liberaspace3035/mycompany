<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// 問い合わせフォーム受信箱。管理画面では閲覧のみ。
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contact_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('company')->nullable();
            $table->text('body');
            $table->string('source_url')->nullable();   // 送信元 URL
            $table->string('referrer')->nullable();
            $table->string('user_agent')->nullable();
            $table->ipAddress('ip')->nullable();
            $table->boolean('read')->default(false);
            $table->timestamps();

            $table->index(['read', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_submissions');
    }
};
