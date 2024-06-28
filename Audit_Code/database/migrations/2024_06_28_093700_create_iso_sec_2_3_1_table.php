<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iso_sec_2_3_1', function (Blueprint $table) {
            $table->integer('assessment_id', true);
            $table->integer('project_id')->nullable()->index('projid_sec2_3_1');
            $table->integer('asset_id')->nullable()->index('asset_id');
            $table->string('control_num', 100)->nullable();
            $table->string('applicability', 16);
            $table->integer('asset_value');
            $table->integer('control_compliance')->nullable();
            $table->integer('vulnerability')->nullable();
            $table->integer('threat')->nullable();
            $table->decimal('risk_level', 11, 5)->nullable();
            $table->string('residual_risk_treatment', 100)->nullable();
            $table->string('treatment_action', 1000)->nullable();
            $table->date('treatment_target_date')->nullable();
            $table->date('treatment_comp_date')->nullable();
            $table->unsignedBigInteger('responsibility_for_treatment')->nullable();
            $table->unsignedBigInteger('last_edited_by')->nullable()->index('last_edited_by');
            $table->dateTime('last_edited_at');

            $table->unique(['asset_id', 'control_num'], 'asset_id_2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('iso_sec_2_3_1');
    }
};
