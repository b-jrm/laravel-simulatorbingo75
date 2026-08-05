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
        Schema::create('cartons_series', function (Blueprint $table) {

            $table->charset = 'utf8';
            $table->collation = 'utf8_spanish_ci';
            
            $table->bigIncrements('carton_serie_id');
            $table->integer('x_axis')->nullable();
            $table->integer('y_axis')->nullable();
            $table->unsignedBigInteger('carton_id')->nullable();
            $table->foreign('carton_id')->references('carton_id')->on('cartons')->nullOnDelete();
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
        Schema::dropIfExists('cartons_series');
    }
};
