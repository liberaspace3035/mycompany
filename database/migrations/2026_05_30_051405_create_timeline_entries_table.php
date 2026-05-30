<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// company.html の沿革タイムライン。
// date は表示用文字列 ('2024.04' 等) を入れる。並び順は position で制御。
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('timeline_entries', function (Blueprint $table) {
            $table->id();
            $table->string('date', 32);
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedSmallInteger('position')->default(0);
            $table->timestamps();

            $table->index('position');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('timeline_entries');
    }
};
