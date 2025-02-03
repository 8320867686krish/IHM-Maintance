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
        Schema::create('assign_taraining_sets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('training_sets_id')->nullable();  // Same data type as hazmat_companies.id
            $table->foreign('training_sets_id')->references('id')->on('training_sets')->onDelete('cascade');
            $table->unsignedBigInteger('hazmat_companies_id')->nullable();  // Same data type as hazmat_companies.id
            $table->foreign('hazmat_companies_id')->references('id')->on('hazmat_companies')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assign_taraning_sets');
    }
};
