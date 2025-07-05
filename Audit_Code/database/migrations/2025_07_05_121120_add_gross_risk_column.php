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
            $table->integer('financial_impact')->nullable();
            $table->integer('criticality_on_revenue')->nullable();
            $table->integer('financial_ecosystem')->nullable();
            $table->integer('geog_service_devilery')->nullable();
            $table->integer('strategic_importance')->nullable();
            $table->integer('criticality_of_customer_base')->nullable();
            $table->integer('monthly_transactions')->nullable();
            $table->integer('reg_comp_obligations')->nullable();
            $table->integer('dependency_on_external_vendors')->nullable();
            $table->integer('extent_of_functions')->nullable();
            $table->integer('total_impact_rating')->nullable();

            $table->decimal('blank1')->nullable();
            $table->integer('blank2')->nullable();
            $table->decimal('blank3')->nullable();

            $table->string('overall_impact')->nullable();
            $table->string('inherent_risk_rating')->nullable();

            $table->string('likelihood')->nullable();

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
