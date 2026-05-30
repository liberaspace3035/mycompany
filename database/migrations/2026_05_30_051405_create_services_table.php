<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// 提供サービス。features / pricing は JSON で柔軟に。
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('eyebrow')->nullable();          // 'SERVICE 01'
            $table->text('summary')->nullable();
            $table->json('features')->nullable();           // ['コーポレートサイト', 'LP', ...]
            $table->json('pricing')->nullable();            // [{plan, price, scope[], featured?}]
            $table->json('keywords')->nullable();           // 補助タグ
            $table->unsignedSmallInteger('position')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
