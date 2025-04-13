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
        Schema::create('proj_asset_likelihood_confidentiality_timeframe', function (Blueprint $table) {
            $table->id('proj_asset_likelihood_confidentiality_timeframe_id');
            $table->integer('timeframe');

            $table->integer('project_id')->nullable()->index('projid_sec2_3_1_qa2');
            $table->integer('asset_id')->nullable()->index('asset_id_sec2_3_1_qa2');
            $table->unsignedBigInteger('last_edited_by')->nullable()->index('last_edited_by');
           
            $table->foreign(['asset_id'], 'ass_id_ltf_2_1')->references(['assessment_id'])->on('iso_sec_2_1')->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->foreign(['last_edited_by'], 'lastEdk_2_3_1_ltffk1')->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('SET NULL');

            $table->foreign(['project_id'], 'projid_qa_a_rsltf3')->references(['project_id'])->on('projects')->onUpdate('CASCADE')->onDelete('CASCADE');

             $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proj_asset_likelihood_confidentiality_timeframe');
    }
};
