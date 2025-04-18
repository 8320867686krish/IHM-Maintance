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
        Schema::create('email_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ship_id')->nullable();  // Same data type as hazmat_companies.id
            $table->foreign('ship_id')->references('id')->on('ships')->onDelete('cascade');
            $table->unsignedBigInteger('po_order_id')->nullable();  // Same data type as hazmat_companies.id
            $table->foreign('po_order_id')->references('id')->on('po_orders')->onDelete('cascade');
            $table->string('from_email')->nullable();
            $table->string('suppliear_email')->nullable();
            $table->string('company_email')->nullable();
            $table->string('accounting_email')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_histories');
    }
};
