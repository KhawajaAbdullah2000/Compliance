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
        Schema::create('org_risk_assessment_approach', function (Blueprint $table) {
            $table->id('org_risk_assessment_approach_id');
            $table->unsignedBigInteger('org_id');
            $table->unsignedBigInteger('project_type_id');
             $table->unsignedBigInteger('assessment_approach_selected')->nullable();
             $table->foreign('org_id')->references('id')->on('organizations')->onDelete('cascade');
             $table->foreign('project_type_id')->references('id')->on('project_types')->onDelete('cascade');
             $table->foreign('assessment_approach_selected','org_ass_app_fk')->references('global_risk_assessment_approach_id')->on('global_risk_assessment_approach')->onDelete('cascade')->onUpdate('cascade');

             $table->unique(['org_id','project_type_id']);

             $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
