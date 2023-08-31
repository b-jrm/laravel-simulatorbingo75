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
        Schema::create('countries_documents', function (Blueprint $table) {

            $table->charset = 'utf8';
            $table->collation = 'utf8_spanish_ci';
            
            $table->bigIncrements('country_document_id');
            $table->unsignedBigInteger('document_id')->nullable();
            $table->foreign('document_id')->references('document_id')->on('documents')->nullOnDelete();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->foreign('country_id')->references('country_id')->on('countries')->nullOnDelete();
            $table->enum('status',[0,1])->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries_documents');
    }
};
