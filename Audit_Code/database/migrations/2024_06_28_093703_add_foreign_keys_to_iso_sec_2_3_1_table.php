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
        Schema::table('iso_sec_2_3_1', function (Blueprint $table) {
            $table->foreign(['asset_id'], 'assetid_sec2_3_1FK')->references(['assessment_id'])->on('iso_sec_2_1')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['project_id'], 'projid_2_3')->references(['project_id'])->on('projects')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['last_edited_by'], 'lastEdit_fk_2_3_1')->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('iso_sec_2_3_1', function (Blueprint $table) {
            $table->dropForeign('assetid_sec2_3_1FK');
            $table->dropForeign('projid_2_3');
            $table->dropForeign('lastEdit_fk_2_3_1');
        });
    }
};
