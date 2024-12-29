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
        Schema::create('organization_project_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('org_id');

            $table->unsignedBigInteger('project_type_id');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('org_id')->references('org_id')->on('organizations')->onDelete('cascade');
            $table->foreign('project_type_id')->references('id')->on('project_types')->onDelete('cascade');

            // Prevent duplicate entries for the same organization and project type
            $table->unique(['org_id', 'project_type_id'], 'org_project_unique');
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
