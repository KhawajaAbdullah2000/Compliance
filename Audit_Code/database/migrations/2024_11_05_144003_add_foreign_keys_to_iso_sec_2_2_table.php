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
        Schema::table('iso_sec_2_2', function (Blueprint $table) {
            $table->foreign(['last_edited_by'], 'iso_sec2_2edit')->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('SET NULL');
            $table->foreign(['project_id'], 'iso_sec2_2projid')->references(['project_id'])->on('projects')->onUpdate('CASCADE')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('iso_sec_2_2', function (Blueprint $table) {
            $table->dropForeign('iso_sec2_2edit');
            $table->dropForeign('iso_sec2_2projid');
        });
    }
};
