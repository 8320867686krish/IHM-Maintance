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
        Schema::create('designated_persion_ships', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ship_id')->nullable();  // Same data type as hazmat_companies.id
            $table->foreign('ship_id')->references('id')->on('ships')->onDelete('cascade');
            $table->unsignedBigInteger('designated_person_id')->nullable();  // Same data type as hazmat_companies.id
            $table->foreign('designated_person_id')->references('id')->on('designated_people')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('designated_persion_ships');
    }
};
