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
         Schema::create('incident_reference_catalog', function (Blueprint $table) {
            $table->id();
            $table->string('description', 191)->unique();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });

         Schema::create('external_audit_observation_catalog', function (Blueprint $table) {
            $table->id();
            $table->string('description', 191)->unique();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });

        Schema::create('internal_audit_observation_catalog', function (Blueprint $table) {
            $table->id();
            $table->string('description', 191)->unique();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });

        Schema::create('risk_mitigation_plan', function (Blueprint $table) {
            $table->id();
            $table->string('description', 191)->unique();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
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
