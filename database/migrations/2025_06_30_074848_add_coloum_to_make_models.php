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
        Schema::table('make_models', function (Blueprint $table) {
            //
            $table->string("md_qty")->nullable();
            $table->string("md_unit")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('make_models', function (Blueprint $table) {
            //
        });
    }
};
