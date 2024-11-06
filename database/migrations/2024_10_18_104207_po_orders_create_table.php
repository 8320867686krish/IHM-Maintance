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
        //
        Schema::create('po_orders', function (Blueprint $table) {
            $table->id();
            $table->string('po_no')->nullable();
            $table->unsignedBigInteger('ship_id')->nullable();  // Same data type as hazmat_companies.id
            $table->foreign('ship_id')->references('id')->on('ships')->onDelete('cascade');
          
            $table->string('po_date')->nullable();
            $table->string('vessel_name')->nullable();
            $table->string('machinery')->nullable();
            $table->string('make_model')->nullable();
            $table->string('supplier_name')->nullable();
            $table->string('address')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('phone',20)->nullable();
            $table->string('delivery_location')->nullable();
            $table->date('onboard_reciving_date')->nullable();

            $table->string('email')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
