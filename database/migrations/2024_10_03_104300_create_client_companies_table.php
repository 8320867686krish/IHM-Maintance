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
        Schema::create('client_companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('manager_initials');
            $table->string('ship_owner_email')->nullable();
            $table->string('ship_owner_name')->nullable();
            $table->string('ship_owner_address')->nullable();
            $table->string('ship_owner_phone')->nullable();
            $table->string('contact_person_name')->nullable();
            $table->string('owner_contact_person_email')->nullable();
            $table->string('contact_person_phone')->nullable();
            $table->string('contact_person_designation')->nullable();
            $table->string('tax_details')->nullable();
            $table->string('IMO_ship_owner_details');
            $table->string('client_image')->nullable();

            $table->unsignedBigInteger('created_by')->nullable();  // Same data type as hazmat_companies.id
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('user_id')->nullable();  // Same data type as hazmat_companies.id
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('client_companies');
    }
};
