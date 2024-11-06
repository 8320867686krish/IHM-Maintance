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
        Schema::create('make_models', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hazmat_id');
            $table->unsignedBigInteger('hazmat_companies_id')->nullable();  // Same data type as hazmat_companies.id
            $table->foreign('hazmat_id')->references('id')->on('hazmats')->onDelete('cascade');
            $table->foreign('hazmat_companies_id')->references('id')->on('hazmat_companies')->onDelete('cascade');
            $table->string('equipment')->nullable();
            $table->string('model')->nullable();
            $table->string('make')->nullable();
            $table->string('manufacturer')->nullable();
            $table->string('part')->nullable();
            $table->string('document1')->nullable();
            $table->string('document2')->nullable();
            $table->string('ref_no')->nullable();
         
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('make_models');
    }
};
