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
        Schema::create('countries', function (Blueprint $table) {

            $table->charset = 'utf8';
            $table->collation = 'utf8_spanish_ci';
            
            $table->bigIncrements('country_id');
            $table->string('name');
            $table->string('zip')->nullable();
            $table->string('indicative')->nullable();
            $table->string('language')->default('en');
            $table->string('currency')->nullable();
            $table->unsignedBigInteger('continent_id')->nullable();
            $table->foreign('continent_id')->references('continent_id')->on('continents')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
