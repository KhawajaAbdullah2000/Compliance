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
            $table->integer('assessment_id', true);
            $table->integer('project_id')->nullable()->index('project_id');
            $table->string('g_name', 100);
            $table->string('name', 100);
            $table->string('c_name', 100);
            $table->string('s_name', 100);
            $table->string('owner_dept', 300);
            $table->string('physical_loc', 300);
            $table->string('logical_loc', 300);
            $table->integer('risk_confidentiality')->default(10);
            $table->integer('risk_integrity')->default(10);
            $table->integer('risk_availability')->default(10);
            $table->unsignedBigInteger('last_edited_by')->nullable()->index('last_edited_by');
            $table->dateTime('last_edited_at');

            $table->unique(['project_id', 'g_name', 'name', 'c_name', 's_name'], 'project_id_2');
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
