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
        Schema::create('asset_catalog', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('organization_id')->index();
            $table->string('g_name', 100)->nullable();    // group name (if you need it)
            $table->string('name', 100)->nullable();      // asset/service name
            $table->string('c_name', 100);                // category
            $table->string('s_name', 100)->nullable();    // sub-category
            $table->string('owner_dept', 300);
            $table->string('physical_loc', 300)->nullable();
            $table->string('logical_loc', 300)->nullable();

            // Default/typical risk profile at org level
            $table->integer('risk_confidentiality')->default(10);
            $table->integer('risk_integrity')->default(10);
            $table->integer('risk_availability')->default(10);

            // People (optional at catalog level)
            $table->unsignedBigInteger('service_risk_owner')->nullable()->index();
            $table->unsignedBigInteger('component_risk_owner')->nullable()->index();
            $table->unsignedBigInteger('service_custodian')->nullable()->index();
            $table->unsignedBigInteger('component_custodian')->nullable()->index();

            $table->unsignedBigInteger('last_edited_by')->nullable()->index();
            $table->dateTime('last_edited_at')->nullable();

            $table->timestamps();

            $table->foreign('organization_id')->references('id')->on('organizations')->cascadeOnDelete();
            $table->foreign('service_risk_owner')->references('id')->on('users')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('component_risk_owner')->references('id')->on('users')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('service_custodian')->references('id')->on('users')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('component_custodian')->references('id')->on('users')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('last_edited_by')->references('id')->on('users')->nullOnDelete()->cascadeOnUpdate();

    
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
