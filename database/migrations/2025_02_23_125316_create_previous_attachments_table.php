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
        Schema::create('previous_attachments', function (Blueprint $table) {
            $table->id();
            $table->string('attachment_name')->nullable();
            $table->date('date_from')->nullable();
            $table->date('date_till')->nullable();
            $table->string('maintained_by')->nullable();
            $table->string('attachment')->nullable();
            $table->unsignedBigInteger('ship_id')->nullable();  // Same data type as hazmat_companies.id
            $table->foreign('ship_id')->references('id')->on('ships')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('previous_attachments');
    }
};
