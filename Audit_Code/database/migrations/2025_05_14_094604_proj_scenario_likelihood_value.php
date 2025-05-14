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
          Schema::create('proj_scenario_likelihood_value', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('likelihood_selected');
            $table->unsignedBigInteger('scenario');

            $table->integer('project_id')->nullable()->index('projid_sec_proj_sce_qa33');

            $table->unsignedBigInteger('last_edited_by')->nullable()->index('last_edited_by');
           
            $table->foreign(['last_edited_by'], 'likeproj_scenfk666')->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('SET NULL');

            
            $table->foreign('likelihood_selected')->references(['global_likelihood_value_id'])->on('global_likelihood_value')->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->foreign('scenario')->references('id')->on('party_scenarios')->onDelete('Cascade')->onUpdate('Cascade');

             $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proj_scenario_likelihood_value');
    }
};
