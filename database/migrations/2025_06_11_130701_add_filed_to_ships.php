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
        Schema::table('ships', function (Blueprint $table) {
            
            $table->string('report_number')->nullable();
            $table->string('initial_address')->nullable();
            $table->string('ship_owner_name_initial')->nullable();
            $table->string('ship_owner_address_initial')->nullable();
            $table->string('manager_address_initial')->nullable();
            $table->string('manager_name_initial')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ships', function (Blueprint $table) {
            //
        });
    }
};
