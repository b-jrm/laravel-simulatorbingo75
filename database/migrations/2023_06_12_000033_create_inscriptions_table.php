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
        Schema::create('inscriptions', function (Blueprint $table) {

            $table->charset = 'utf8';
            $table->collation = 'utf8_spanish_ci';
            
            $table->bigIncrements('inscription_id');
            $table->unsignedBigInteger('player_id')->nullable();
            $table->foreign('player_id')->references('player_id')->on('players')->nullOnDelete();
            $table->unsignedBigInteger('game_id')->nullable();
            $table->foreign('game_id')->references('game_id')->on('games')->nullOnDelete();
            $table->string('cartons_ids');
            $table->enum('status',[0,1])->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscriptions');
    }
};
