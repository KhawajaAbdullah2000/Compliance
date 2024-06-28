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
        Schema::table('superusers', function (Blueprint $table) {
            $table->foreign(['org_id'], 'orgidfk')->references(['org_id'])->on('organizations')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['user_id'], 'useridfk')->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('superusers', function (Blueprint $table) {
            $table->dropForeign('orgidfk');
            $table->dropForeign('useridfk');
        });
    }
};
