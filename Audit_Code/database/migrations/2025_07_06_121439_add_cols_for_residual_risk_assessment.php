<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('one_link_risk_record', function (Blueprint $table) {
      
           //$table->unsignedInteger('control_ref_num')->nullable()->unique(); not possible when already have a primary key auto increment so use primary key as control ref

           //catalogs
           $table->longText('control_objective')->nullable();
           $table->longText('control_description')->nullable();
           $table->longText('control_type')->nullable();
           $table->longText('document_reference')->nullable();
           $table->longText('sub_process_reference')->nullable();
           $table->longText('application')->nullable();

           //dropdowns
           $table->string('coso_component')->nullable();
           $table->string('nature_of_control')->nullable();
           $table->string('control_mechanism')->nullable();
           $table->string('recurrence_of_control')->nullable();
           $table->string('frequency_application')->nullable();
           $table->string('key_control')->nullable(); //yes or no

           //number dropdown
           $table->integer('policy')->nullable();
           $table->integer('sop')->nullable();
           $table->integer('marker_checker_control')->nullable();
           $table->integer('ownership')->nullable();
           $table->integer('control_design_review')->nullable();
           $table->integer('diagnosis_of_control')->nullable();
           $table->integer('meets_control_obj')->nullable();
           $table->integer('complaints_management')->nullable();
           $table->integer('control_design_ass')->nullable();
           $table->integer('control_implementation')->nullable();
           $table->integer('control_rating')->nullable();
           $table->decimal('residual_risk_rating')->nullable();


            //users
           $table->unsignedBigInteger('control_owner')->nullable();
           $table->unsignedBigInteger('technology_support')->nullable();


           $table->foreign('control_owner')->references('id')->on('users')->onDelete('set null');
           $table->foreign('technology_support','fk_tech_onel')->references('id')->on('users')->onDelete('set null');



      

        });

     


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('one_link_risk_record', function (Blueprint $table) {
            //
        });
    }
};
