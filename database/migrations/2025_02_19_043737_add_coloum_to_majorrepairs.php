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
        Schema::table('majorrepairs', function (Blueprint $table) {
            //
            $table->string('after_image')->nullable();
            $table->string('before_image')->nullable();
            $table->date('entry_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('majorrepairs', function (Blueprint $table) {
            //
        });
    }
};
