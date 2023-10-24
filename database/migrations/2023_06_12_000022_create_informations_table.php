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
        Schema::create('informations', function (Blueprint $table) {

            $table->charset = 'utf8';
            $table->collation = 'utf8_spanish_ci';
            
            $table->bigIncrements('information_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('user_id')->on('users')->nullOnDelete();
            $table->string('nickname');
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->unsignedBigInteger('document_id')->nullable();
            $table->foreign('document_id')->references('document_id')->on('documents')->nullOnDelete();
            $table->string('numberdocument')->nullable();
            $table->string('photo')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('address')->nullable();
            $table->date('birthdate')->nullable();
            $table->enum('gender',['M','F','I'])->default('I');
            $table->string('language')->default('en');
            $table->unsignedBigInteger('location_id')->nullable();
            $table->foreign('location_id')->references('location_id')->on('locations')->nullOnDelete();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->foreign('city_id')->references('city_id')->on('cities')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informations');
    }
};
