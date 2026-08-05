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
        Schema::create('submodes_coordinates', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_spanish_ci';
            $table->bigIncrements('submode_coordinate_id');
            $table->unsignedBigInteger('submode_id')->nullable();
            $table->foreign('submode_id')->references('submode_id')->on('submodes')->nullOnDelete();
            $table->unsignedBigInteger('coordinate_id')->nullable();
            $table->foreign('coordinate_id')->references('coordinate_id')->on('coordinates')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modes_coordinates');
    }
};
