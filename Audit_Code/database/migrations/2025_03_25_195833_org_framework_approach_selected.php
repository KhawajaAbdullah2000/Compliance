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
             $table->unsignedBigInteger('org_projects_framework_selected');
             $table->unsignedBigInteger('framework_approach_types');

             $table->foreign('org_projects_framework_selected', 'fk_opf_selected')->references('org_projects_framework_selected_id')->on('org_projects_framework_selected')->onDelete('cascade')->onUpdate('cascade');

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
