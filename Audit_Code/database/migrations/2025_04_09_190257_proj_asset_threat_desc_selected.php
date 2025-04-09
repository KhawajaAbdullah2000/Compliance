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
        Schema::create('proj_asset_threat_desc_selected', function (Blueprint $table) {

            $table->id('proj_asset_threat_desc_selected_id');
            $table->unsignedBigInteger('threat_desc_selected');

            $table->integer('project_id')->nullable()->index('projid_sec2_3_1_qa2');
            $table->integer('asset_id')->nullable()->index('asset_id_sec2_3_1_qa2');
            $table->unsignedBigInteger('last_edited_by')->nullable()->index('last_edited_by');
           
            $table->foreign(['asset_id'], 'ass_id__thr_fk_2_1')->references(['assessment_id'])->on('iso_sec_2_1')->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->foreign(['last_edited_by'], 'lastEdk_2_3_1_qa_thrfk3')->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('SET NULL');

            $table->foreign(['project_id'], 'projid_qa_a_riskfk_thr3')->references(['project_id'])->on('projects')->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->foreign('threat_desc_selected','vuln_as_fk1_th_se')->references('threat_desc_for_global_threats_id')->on('threat_desc_for_global_threats')->onDelete('cascade')->onUpdate('cascade');

             $table->timestamps();
    });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proj_asset_threat_desc_selected');
    }
};
