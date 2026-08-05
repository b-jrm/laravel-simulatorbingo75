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
        Schema::create('games', function (Blueprint $table) {

            $table->charset = 'utf8';
            $table->collation = 'utf8_spanish_ci';
            $table->bigIncrements('game_id');
            $table->timestamp('time_start')->nullable();
            $table->integer('max_players');
            $table->integer('min_players');
            $table->decimal('price_bet', 11, 2);
            $table->decimal('price_win', 11, 2);
            $table->unsignedBigInteger('context_id')->nullable();
            $table->foreign('context_id')->references('context_id')->on('contexts')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
