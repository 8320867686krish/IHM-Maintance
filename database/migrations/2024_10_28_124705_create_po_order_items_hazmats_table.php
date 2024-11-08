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
        Schema::create('po_order_items_hazmats', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('ship_id')->nullable();  // Same data type as hazmat_companies.id
            $table->foreign('ship_id')->references('id')->on('ships')->onDelete('cascade');


            $table->unsignedBigInteger('po_order_id')->nullable();  // Same data type as hazmat_companies.id
            $table->foreign('po_order_id')->references('id')->on('po_orders')->onDelete('cascade');

            $table->unsignedBigInteger('po_order_item_id')->nullable();  // Same data type as hazmat_companies.id
            $table->foreign('po_order_item_id')->references('id')->on('po_order_items')->onDelete('cascade');

            $table->unsignedBigInteger('hazmat_id')->nullable();  // Same data type as hazmat_companies.id
            $table->foreign('hazmat_id')->references('id')->on('hazmats')->onDelete('cascade');

            $table->string('hazmat_type')->nullable();
            $table->boolean('isArrived')->default(0);
            $table->boolean('isRemove')->default(0);
            $table->string('service_supplier_name')->nullable();
            $table->string('service_supplier_address')->nullable();
            $table->date('removal_date')->nullable();
            $table->string('removal_location')->nullable();
            $table->string('attachment')->nullable();
            $table->string('po_no')->nullable();
            $table->boolean('isReturn')->default(0);
            $table->boolean('isInstalled')->default(0);
            $table->string('location')->nullable();
            $table->date('date')->nullable();
            $table->boolean('isIHMUpdated')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('po_order_items_hazmats');
    }
};
