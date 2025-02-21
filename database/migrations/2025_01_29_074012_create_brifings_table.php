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
        Schema::create('brifings', function (Blueprint $table) {
            $table->id();
            $table->string('number_of_attendance',10)->nullable();
            $table->date('brifing_date')->nullable();
            $table->string('brifing_document')->nullable();

            $table->unsignedBigInteger('designated_people_id')->nullable();
            $table->foreign('designated_people_id')->references('id')->on('designated_people')->onDelete('cascade');

        

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brifings');
    }
};
