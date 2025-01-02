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
        Schema::create('designated_people', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ship_id')->nullable();  // Same data type as hazmat_companies.id
            $table->foreign('ship_id')->references('id')->on('ships')->onDelete('cascade');


            $table->unsignedBigInteger('ship_staff_id')->nullable();  // Same data type as hazmat_companies.id
            $table->foreign('ship_staff_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('name')->nullable();
            $table->string('rank')->nullable();
            $table->string('passport_number')->nullable();
            $table->string('position',20)->nullable();
            $table->date('sign_on_date')->nullable();
            $table->date('sign_off_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('designated_people');
    }
};
