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
        Schema::create('control_objective_catalog', function (Blueprint $table) {
            $table->id();
            $table->string('description', 191)->unique();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });

         Schema::create('control_description_catalog', function (Blueprint $table) {
            $table->id();
            $table->string('description', 191)->unique();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });

         Schema::create('control_type_catalog', function (Blueprint $table) {
            $table->id();
            $table->string('description', 191)->unique();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });

         Schema::create('document_reference', function (Blueprint $table) {
            $table->id();
            $table->string('description', 191)->unique();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });

        
         Schema::create('sub_process_reference', function (Blueprint $table) {
            $table->id();
            $table->string('description', 191)->unique();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });

         Schema::create('application', function (Blueprint $table) {
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
        Schema::dropIfExists('residual_risk_catalog');
        Schema::dropIfExists('control_description_catalog');
        Schema::dropIfExists('control_type_catalog');
        Schema::dropIfExists('document_reference');
        Schema::dropIfExists('sub_process_reference');
        Schema::dropIfExists('application');
    }
};
