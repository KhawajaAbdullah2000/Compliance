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
        Schema::table('iso_risk_treatment', function (Blueprint $table) {
            $table->foreign(['acceptance_proposed_responsibility'], 'acceptace_flk1')->references(['id'])->on('users')->onUpdate('SET NULL')->onDelete('SET NULL');
            $table->foreign(['accepted_by'], 'acceptace_flk2')->references(['id'])->on('users')->onUpdate('SET NULL')->onDelete('SET NULL');
            $table->foreign(['last_edited_by'], 'acceptace_flk3')->references(['id'])->on('users')->onUpdate('SET NULL')->onDelete('SET NULL');
            $table->foreign(['asset_id'], 'assetid')->references(['assessment_id'])->on('iso_sec_2_1')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('iso_risk_treatment', function (Blueprint $table) {
            $table->dropForeign('acceptace_flk1');
            $table->dropForeign('acceptace_flk2');
            $table->dropForeign('acceptace_flk3');
            $table->dropForeign('assetid');
        });
    }
};
