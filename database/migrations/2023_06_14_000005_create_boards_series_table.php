<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('boards_series', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_spanish_ci';
            $table->bigIncrements('board_serie_id');
            $table->unsignedBigInteger('board_id')->nullable();
            $table->foreign('board_id')->references('board_id')->on('boards')->nullOnDelete();
            $table->unsignedBigInteger('serie_id')->nullable();
            $table->foreign('serie_id')->references('serie_id')->on('series')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boards_series');
    }
};
