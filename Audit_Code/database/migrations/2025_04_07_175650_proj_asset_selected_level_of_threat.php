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
        Schema::create('proj_asset_selected_level_of_threat', function (Blueprint $table) {
            $table->id('proj_asset_selected_level_of_threat_id');
            $table->unsignedBigInteger('threat_selected');

            $table->integer('project_id')->nullable()->index('projid_sec2_3_1_qa');
            $table->integer('asset_id')->nullable()->index('asset_id_sec2_3_1_qa');
            $table->unsignedBigInteger('last_edited_by')->nullable()->index('last_edited_by');
           
            $table->foreign(['asset_id'], 'ass_id_fk_2')->references(['assessment_id'])->on('iso_sec_2_1')->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->foreign(['last_edited_by'], 'lastEdfk_2_3_1_qasafk2')->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('SET NULL');

            $table->foreign(['project_id'], 'projid_qa_riskfk2')->references(['project_id'])->on('projects')->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->foreign('threat_selected','thre_as_fk1')->references('global_level_of_threats_id')->on('global_level_of_threats')->onDelete('cascade')->onUpdate('cascade');

             $table->timestamps();
          

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proj_asset_selected_level_of_threat');

    }
};
