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
        Schema::create('proj_assets_selected_risk_source_and_target', function (Blueprint $table) {
            $table->id('proj_ass_risk_src_target_id');
            $table->unsignedBigInteger('risk_source_foreign');
            $table->unsignedBigInteger('target_object_foreign');
            $table->integer('project_id')->nullable()->index('projid_sec2_3_1_qa');
            $table->integer('asset_id')->nullable()->index('asset_id_sec2_3_1_qa');
            $table->unsignedBigInteger('last_edited_by')->nullable()->index('last_edited_by');

            $table->timestamps();


            $table->foreign('risk_source_foreign','rskfor1fk')->references('qualitative_asset_based_risk_sources_id')->on('qualitative_asset_based_risk_sources')->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('target_object_foreign','rskfor2fk')->references('qualitative_asset_global_target_object_risk_source_id')->on('qualitative_asset_global_target_object_risk_source')->onDelete('cascade')->onUpdate('cascade');

            $table->foreign(['asset_id'], 'ass_id_fk_1')->references(['assessment_id'])->on('iso_sec_2_1')->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->foreign(['last_edited_by'], 'lastEdit_fk_2_3_1_qasa')->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('SET NULL');

            $table->foreign(['project_id'], 'projid_2_3_qa_risk')->references(['project_id'])->on('projects')->onUpdate('CASCADE')->onDelete('CASCADE');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proj_assets_selected_risk_source_and_target');

    }
};
