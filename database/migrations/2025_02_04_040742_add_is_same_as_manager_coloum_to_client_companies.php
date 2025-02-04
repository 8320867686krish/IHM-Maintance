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
        Schema::table('client_companies', function (Blueprint $table) {
            //
            $table->boolean('isSameAsManager')->default(0);
            $table->string('manager_address')->nullable();
            $table->string('manager_contact_person_name')->nullable();
            $table->string('manager_contact_person_email')->nullable();
            $table->string('manager_contact_person_phone')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('client_companies', function (Blueprint $table) {
            //
        });
    }
};
