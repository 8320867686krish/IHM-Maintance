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
        Schema::create('make_models', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hazmat_id');
            $table->unsignedBigInteger('hazmat_companies_id')->nullable();  // Same data type as hazmat_companies.id
            $table->foreign('hazmat_id')->references('id')->on('hazmats')->onDelete('cascade');
            $table->foreign('hazmat_companies_id')->references('id')->on('hazmat_companies')->onDelete('cascade');
            $table->string('equipment')->nullable();
            $table->string('model')->nullable();
            $table->string('make')->nullable();
            $table->string('manufacturer')->nullable();
            $table->string('part')->nullable();
            $table->string('document1')->nullable();
            $table->string('document2')->nullable();
            $table->string('md_no')->nullable();
            $table->string('sdoc_no')->nullable();
            $table->string('sdoc_id_no')->nullable()->after('sdoc_no');
            $table->date('md_date')->nullable()->after('sdoc_id_no');
            $table->date('sdoc_date')->nullable()->after('md_date');
            $table->string('issuer_name')->nullable()->after('sdoc_date');
            $table->text('sdoc_objects')->nullable()->after('issuer_name');
            $table->text('other_information')->nullable()->after('issuer_name');

            $table->string('coumpany_name')->nullable()->after('sdoc_objects');
            $table->string('division_name')->nullable()->after('coumpany_name');
            $table->string('address')->nullable()->after('division_name');
            $table->string('contact_person')->nullable()->after('address');
            $table->string('telephone_number', 25)->nullable()->after('contact_person');
            $table->string('fax_number')->nullable()->after('telephone_number');
            $table->string('email_address')->nullable()->after('fax_number');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('make_models');
    }
};
