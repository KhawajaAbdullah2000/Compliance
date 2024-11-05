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
        Schema::table('iso_sec2_4_a6', function (Blueprint $table) {
            $table->foreign(['asset_id'], 'assrtidfkfor16')->references(['assessment_id'])->on('iso_sec_2_1')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['last_edited_by'], 'edit_sec2_4_16')->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('SET NULL');
            $table->foreign(['project_id'], 'proj_iso_2_4_a6')->references(['project_id'])->on('projects')->onUpdate('CASCADE')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('iso_sec2_4_a6', function (Blueprint $table) {
            $table->dropForeign('assrtidfkfor16');
            $table->dropForeign('edit_sec2_4_16');
            $table->dropForeign('proj_iso_2_4_a6');
        });
    }
};
