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
        Schema::table('po_order_items_hazmats', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('model_make_part_id')->nullable();
            $table->foreign('model_make_part_id')->references('id')->on('make_models')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('po_order_items_hazmats', function (Blueprint $table) {
            //
        });
    }
};
