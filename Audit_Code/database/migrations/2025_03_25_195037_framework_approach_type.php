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
        Schema::create('framework_approach_types', function (Blueprint $table) {
            $table->id('framework_approach_types_id');
            $table->string('approach_name');
            // $table->unsignedBigInteger('org_projects_framework');
            // $table->foreign('org_projects_framework')->references('org_projects_framework_selected_id')->on('org_projects_framework_selected')->onDelete('cascade');
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
