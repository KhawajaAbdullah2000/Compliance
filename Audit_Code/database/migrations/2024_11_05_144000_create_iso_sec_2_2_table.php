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
        Schema::create('iso_sec_2_2', function (Blueprint $table) {
            $table->integer('assessment_id', true);
            $table->integer('project_id')->nullable()->index('project_id_2');
            $table->string('title_num',100)->nullable();
            $table->string('sub_req', 100)->nullable();
            $table->string('comp_status', 10)->nullable();
            $table->string('comments', 3000)->nullable();
            $table->string('attachment', 1000)->nullable();
            $table->unsignedBigInteger('last_edited_by')->nullable()->index('last_edited_by');
            $table->dateTime('last_edited_at');
            $table->unique(['project_id', 'sub_req'], 'project_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('iso_sec_2_2');
    }
};
