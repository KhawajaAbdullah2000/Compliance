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
        Schema::create('qualitative_risk_acceptance_criteria', function (Blueprint $table) {
            $table->id('qualitative_risk_acceptance_criteria_id');
            $table->unsignedBigInteger('org_id');
            $table->unsignedBigInteger('project_type_id');
             $table->string('criteria_selected');
             $table->foreign('org_id')->references('id')->on('organizations')->onDelete('cascade');
             $table->foreign('project_type_id')->references('id')->on('project_types')->onDelete('cascade');
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
