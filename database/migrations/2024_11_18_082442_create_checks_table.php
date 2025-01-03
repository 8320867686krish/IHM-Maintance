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
        Schema::create('checks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ship_id')->nullable();
            $table->foreign('ship_id')->references('id')->on('ships')->onDelete('cascade');
            $table->unsignedBigInteger('deck_id')->nullable();
            $table->foreign('deck_id')->references('id')->on('decks')->onDelete('cascade');
            $table->string('type',30)->nullable();
            $table->string('name')->nullable();
            $table->string('position_left')->nullable();
            $table->string('position_top')->nullable();
            $table->string('initialsChekId')->nullable();
            $table->string('close_image')->nullable();
            $table->string('away_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checks');
    }
};
