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
        Schema::create('org_framework_approach_selected', function (Blueprint $table) {
            $table->id('org_framework_approach_selected_id');
            $table->unsignedBigInteger('org_id');
            $table->unsignedBigInteger('project_type_id');
             $table->unsignedBigInteger('framework_approach_types')->nullable();
             $table->foreign('org_id')->references('id')->on('organizations')->onDelete('cascade');
             $table->foreign('project_type_id')->references('id')->on('project_types')->onDelete('cascade');

            $table->foreign('framework_approach_types')->references('framework_approach_types_id')->on('framework_approach_types')->onDelete('cascade')->onUpdate('cascade');
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
