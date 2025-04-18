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
        Schema::table('configrations', function (Blueprint $table) {
            $table->string('training_material')->nullable();
            $table->string('briefing_material')->nullable();
            $table->string('sms_extract')->nullable();
            $table->string('operation_manual')->nullable();
            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('configrations', function (Blueprint $table) {
            //
        });
    }
};
