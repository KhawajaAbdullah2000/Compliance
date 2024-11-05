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
        Schema::create('iso_sec_2_3', function (Blueprint $table) {
            $table->integer('sec2_3_key', true);
            $table->integer('asset_id')->nullable()->index('asset_id_2');
            $table->integer('project_id')->nullable()->index('project_id');
            $table->integer('asset_value');
            $table->unsignedBigInteger('last_edited_by')->nullable()->index('last_edited_by');
            $table->dateTime('last_edited_at');

            $table->unique(['asset_id', 'project_id'], 'asset_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('iso_sec_2_3');
    }
};
