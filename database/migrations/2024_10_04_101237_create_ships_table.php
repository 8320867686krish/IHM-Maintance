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
        Schema::create('ships', function (Blueprint $table) {
            $table->id();
            
            $table->string('ship_initials')->nullable();
            $table->string('ship_name')->nullable();
            $table->string('ship_type')->nullable();
            $table->string('project_no')->nullable();
            $table->string('imo_number')->nullable()->unique();
            $table->string('call_sign')->nullable();
            $table->string('port_of_registry')->nullable();
            $table->string('ship_image')->nullable();
            $table->string('vessel_class')->nullable();
            $table->string('ihm_class')->nullable();
            $table->string('flag_of_ship')->nullable();
            $table->date('delivery_date')->nullable();
            $table->string('building_details')->nullable();
            $table->string('x_breadth_depth')->nullable();
            $table->string('gross_tonnage')->nullable();
            $table->string('vessel_previous_name')->nullable();
            $table->string('ga_plan_pdf')->nullable();
            $table->string(column: 'ga_plan_image')->nullable();
            $table->boolean(column: 'is_unlock')->default(0);


            $table->date('initial_ihm_date')->nullable();
            $table->string('survey_location')->nullable();
            $table->string('prepared_by')->nullable();
            $table->string('approved_by')->nullable();
            $table->string('current_ihm_version',20)->nullable();
            $table->date('ihm_version_updated_date')->nullable();

            $table->unsignedBigInteger('client_company_id')->nullable();  // Same data type as hazmat_companies.id
            $table->foreign('client_company_id')->references('id')->on('client_companies')->onDelete('cascade');
            $table->unsignedBigInteger('client_user_id')->nullable();  // Same data type as hazmat_companies.id
            $table->foreign('client_user_id')->references('id')->on('users')->onDelete('cascade');
          
            $table->unsignedBigInteger('user_id')->nullable();  // Same data type as hazmat_companies.id
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('hazmat_companies_id')->nullable();  // Same data type as hazmat_companies.id
            $table->foreign('hazmat_companies_id')->references('id')->on('hazmat_companies')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ships');
    }
};
