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
        Schema::create('org_projects_framework_selected', function (Blueprint $table) {
            $table->id('org_projects_framework_selected_id');
            $table->unsignedBigInteger('org_id');
            $table->unsignedBigInteger('project_type_id');
            $table->unsignedBigInteger('framework_selected');
            $table->foreign('org_id')->references('id')->on('organizations')->onDelete('cascade');
            $table->foreign('project_type_id')->references('id')->on('project_types')->onDelete('cascade');
            $table->foreign('framework_selected')->references('framework_id')->on('risk_management_framework')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('org_projects_framework_selected');
    }
};
