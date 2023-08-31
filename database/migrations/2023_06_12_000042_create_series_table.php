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
        Schema::create('series', function (Blueprint $table) {

            $table->charset = 'utf8';
            $table->collation = 'utf8_spanish_ci';
            
            $table->bigIncrements('serie_id');
            $table->unsignedBigInteger('letter_id')->nullable();
            $table->foreign('letter_id')->references('letter_id')->on('letters')->nullOnDelete();
            $table->unsignedBigInteger('number_id')->nullable();
            $table->foreign('number_id')->references('number_id')->on('numbers')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('series');
    }
};
