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
        Schema::table('iso_sec2_4_a5', function (Blueprint $table) {
            $table->foreign(['asset_id'], 'asseid_isofk')->references(['assessment_id'])->on('iso_sec_2_1')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['project_id'], 'isosec2_4_a5_projid')->references(['project_id'])->on('projects')->onUpdate('CASCADE')->onDelete('SET NULL');
            $table->foreign(['last_edited_by'], 'editby-iso_2_4_a5')->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('iso_sec2_4_a5', function (Blueprint $table) {
            $table->dropForeign('asseid_isofk');
            $table->dropForeign('isosec2_4_a5_projid');
            $table->dropForeign('editby-iso_2_4_a5');
        });
    }
};
