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
        Schema::table('proj_asset_likelihood_value', function (Blueprint $table) {
            $table->integer('risk_treatment_likelihood_risk_confidentiality')->nullable();
            $table->integer('risk_treatment_likelihood_risk_integrity')->nullable();
             $table->integer('risk_treatment_likelihood_risk_availability')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proj_asset_likelihood_value', function (Blueprint $table) {
            //
        });
    }
};
