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
        Schema::create('iso27005_risk_assessment', function (Blueprint $table) {
            $table->id('iso27005_risk_assessment_id');
            $table->integer('project_id')->nullable()->index('projid_sec2_3_1_qa');
            $table->integer('asset_id')->nullable()->index('asset_id_sec2_3_1_qa');
            $table->string('vulnerability_due_to');
            $table->string('control_num');
            $table->unsignedBigInteger('last_edited_by')->nullable()->index('last_edited_by');
           
            $table->foreign(['asset_id'], 'ass_id_fk_3')->references(['assessment_id'])->on('iso_sec_2_1')->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->foreign(['last_edited_by'], 'lastEdfk3_2_1_qfk3')->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('SET NULL');

            $table->foreign(['project_id'], 'projid_a_fk3')->references(['project_id'])->on('projects')->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->unique(['project_id','asset_id','control_num'],'uniqfk444_proj_fk_cont');

             $table->timestamps();
          
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iso27005_risk_assessment');

    }
};
