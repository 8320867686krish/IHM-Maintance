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
        Schema::table('hazmat_companies', function (Blueprint $table) {
            //
            $table->string('briefing_plan')->nullable();
            $table->string('training_material')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hazmat_companies', function (Blueprint $table) {
            //
        });
    }
};
