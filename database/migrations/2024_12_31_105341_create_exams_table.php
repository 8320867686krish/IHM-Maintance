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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ship_id')->nullable();  // Same data type as hazmat_companies.id
            $table->foreign('ship_id')->references('id')->on('ships')->onDelete('cascade');
            
            $table->unsignedBigInteger('designated_person_id')->nullable();  // Same data type as hazmat_companies.id
            $table->foreign('designated_person_id')->references('id')->on('designated_people')->onDelete('cascade');

            $table->unsignedBigInteger('ship_staff_id')->nullable();  // Same data type as hazmat_companies.id
            $table->foreign('ship_staff_id')->references('id')->on('users')->onDelete('cascade');


            $table->integer('correct_ans');
            $table->integer('wrong_ans');
            $table->integer('total_ans');
            $table->string('designated_name');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
