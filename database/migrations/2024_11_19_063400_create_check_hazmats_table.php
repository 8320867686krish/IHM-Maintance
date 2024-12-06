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
        Schema::create('check_hazmats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ship_id')->nullable();
            $table->foreign('ship_id')->references('id')->on('ships')->onDelete('cascade');
            $table->unsignedBigInteger('deck_id')->nullable();
            $table->foreign('deck_id')->references('id')->on('decks')->onDelete('cascade');
            $table->unsignedBigInteger('check_id')->nullable();
            $table->foreign('check_id')->references('id')->on('checks')->onDelete('cascade');
            $table->unsignedBigInteger('hazmat_id')->nullable();
            $table->foreign('hazmat_id')->references('id')->on('hazmats')->onDelete('cascade');

            $table->string('application_of_paint')->nullable();
            $table->string('name_of_paint')->nullable();
            $table->string('location')->nullable();

            $table->string('qty')->nullable();
            $table->string('unit')->nullable();
            $table->string('remarks')->nullable();
            $table->string('ihm_part_table',10)->nullable();
            $table->string('parts_where_used')->nullable();
            $table->string('hazmat_type',10)->nullable();
            $table->text('strike_remarks')->nullable();
            $table->string('strike_document')->nullable();
            $table->date('strike_date')->nullable();
            $table->boolean('isStrike')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('check_hazmats');
    }
};
