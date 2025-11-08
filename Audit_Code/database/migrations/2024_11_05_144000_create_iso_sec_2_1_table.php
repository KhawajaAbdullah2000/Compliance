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
        Schema::create('iso_sec_2_1', function (Blueprint $table) {
            $table->integer('assessment_id');
            $table->integer('project_id')->nullable()->index('project_id');
            $table->string('g_name', 100)->nullable();
            $table->string('name', 100)->nullable();
            $table->string('c_name', 100);
            $table->string('s_name', 100)->nullable();
            $table->string('owner_dept', 300)->nullable();
            $table->string('physical_loc', 300)->nullable();
            $table->string('logical_loc', 300)->nullable();
            $table->integer('risk_confidentiality')->nullable();
            $table->integer('risk_integrity')->nullable();
            $table->integer('risk_availability')->nullable();
            $table->unsignedBigInteger('last_edited_by')->nullable()->index('last_edited_by');
            $table->dateTime('last_edited_at');
          $table->unique(['assessment_id', 'project_id']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('iso_sec_2_1');
    }
};
