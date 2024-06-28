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
        Schema::create('iso_sec2_4_a8', function (Blueprint $table) {
            $table->integer('assessment_id', true);
            $table->integer('project_id')->nullable()->index('project_id_2');
            $table->integer('asset_id')->index('asset_id');
            $table->string('control_num', 100);
            $table->string('justification', 3000)->nullable();
            $table->string('ref_of_risk', 3000)->nullable();
            $table->unsignedBigInteger('last_edited_by')->nullable()->index('last_edited_by');
            $table->dateTime('last_edited_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('iso_sec2_4_a8');
    }
};
