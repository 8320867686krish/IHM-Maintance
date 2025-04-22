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
        Schema::create('audit_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_company_id')->nullable();
            $table->foreign('client_company_id')->references('id')->on('client_companies')->onDelete('cascade');
            
            $table->unsignedBigInteger('hazmat_companies_id')->nullable();  // Same data type as hazmat_companies.id
            $table->foreign('hazmat_companies_id')->references('id')->on('hazmat_companies')->onDelete('cascade');

            $table->date('date');
            $table->string("attachment");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_records');
    }
};
