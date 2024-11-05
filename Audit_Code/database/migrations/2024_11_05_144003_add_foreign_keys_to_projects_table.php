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
        Schema::table('projects', function (Blueprint $table) {
            $table->foreign(['created_by'], 'createdbyfk')->references(['id'])->on('users')->onUpdate('SET NULL')->onDelete('SET NULL');
            $table->foreign(['org_id'], 'organfkss')->references(['org_id'])->on('organizations')->onUpdate('SET NULL')->onDelete('SET NULL');
            $table->foreign(['project_type'], 'projtype')->references(['id'])->on('project_types')->onUpdate('SET NULL')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign('createdbyfk');
            $table->dropForeign('organfkss');
            $table->dropForeign('projtype');
        });
    }
};
