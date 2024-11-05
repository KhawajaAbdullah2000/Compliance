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
        Schema::table('iso_sec2_4_a8', function (Blueprint $table) {
            $table->foreign(['asset_id'], 'assetid_a8fk')->references(['assessment_id'])->on('iso_sec_2_1')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['last_edited_by'], 'iso_sec2_4a8_edit')->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('SET NULL');
            $table->foreign(['project_id'], 'iso_sec2_4a8_proj')->references(['project_id'])->on('projects')->onUpdate('CASCADE')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('iso_sec2_4_a8', function (Blueprint $table) {
            $table->dropForeign('assetid_a8fk');
            $table->dropForeign('iso_sec2_4a8_edit');
            $table->dropForeign('iso_sec2_4a8_proj');
        });
    }
};
