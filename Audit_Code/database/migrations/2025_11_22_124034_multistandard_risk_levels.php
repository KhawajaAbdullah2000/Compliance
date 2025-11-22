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
        Schema::create('multistandard_risk_levels',function (Blueprint $table){
            $table->id();
            $table->integer('project_id')->nullable()->index('mul_rsk_proj');
            $table->integer('asset_id')->nullable()->index('mul_rsk_ass');
            $table->unsignedBigInteger('last_edited_by')->nullable()->index('mul_rsk_edit');
            
            $table->unsignedBigInteger('threat_selected')->nullable();
            $table->unsignedBigInteger('vulnerability_selected')->nullable();

            $table->string('threat_free_text')->nullable();
            $table->string('vulnerability_free_text')->nullable();

            $table->integer('threat_level');
            $table->integer('vulnerability_level');
            $table->integer('risk_level');
            $table->string('risk_description')->nullable();

            $table->foreign('threat_selected')
            ->references('qualitative_asset_based_risk_sources_id')
            ->on('qualitative_asset_based_risk_sources')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreign('vulnerability_selected')
            ->references('vul_desc_for_global_vul_id')
            ->on('vul_desc_for_global_vul')
            ->onUpdate('cascade')
            ->onDelete('cascade');


            $table->foreign('asset_id', 'rsk_mul_ass_fk')
                ->references('assessment_id')
                ->on('iso_sec_2_1')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->foreign('last_edited_by', 'rsk_mul_edt_fk')
                ->references('id')
                ->on('users')
                ->onUpdate('CASCADE')
                ->onDelete('SET NULL');

            $table->foreign('project_id', 'rsk_mul_prj_fk')
                ->references('project_id')
                ->on('projects')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');



        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('multistandard_risk_levels');
    }
};
