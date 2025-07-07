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
        Schema::table('one_link_risk_record', function (Blueprint $table) {

            $table->string('risk_response')->nullable();
            $table->string('entity_level_control')->nullable();
            $table->string('implementation_status')->nullable();

            $table->date('review_date')->nullable();
            $table->date('risk_mitigation_target_date')->nullable();
            
            $table->string('key_risk')->nullable();
            $table->string('kri_category')->nullable();
            $table->string('kri_metric')->nullable();
            $table->string('kri_threshold')->nullable();

            

              //catalogs
           $table->longText('incident_reference')->nullable();
           $table->longText('external_audit_observation')->nullable();
           $table->longText('internal_audit_observation')->nullable();
           $table->longText('risk_mitigation_plan')->nullable();
           
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
