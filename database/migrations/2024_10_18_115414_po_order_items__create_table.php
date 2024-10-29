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
        Schema::create('po_order_items', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('ship_id')->nullable();  // Same data type as hazmat_companies.id
            $table->foreign('ship_id')->references('id')->on('ships')->onDelete('cascade');


            $table->unsignedBigInteger('po_order_id')->nullable();  // Same data type as hazmat_companies.id
            $table->foreign('po_order_id')->references('id')->on('po_orders')->onDelete('cascade');

            $table->string('description')->nullable();
            $table->string('part_no')->nullable();
            $table->string('qty')->nullable();
            $table->string('unit_price')->nullable();
            $table->string('amount')->nullable();
            $table->string('type_category',15)->nullable();

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
