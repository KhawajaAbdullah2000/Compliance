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
        Schema::create('organizations', function (Blueprint $table) {
            $table->integer('org_id', true);
            $table->string('name', 100);
            $table->string('type', 100);
            $table->string('sub_org', 100);
            $table->string('country', 100);
            $table->string('state', 100);
            $table->string('city', 100);
            $table->integer('zip_code');
            $table->string('address', 100);
            $table->string('record_created_by', 100);
            $table->date('record_creation_date');
            $table->time('record_creation_time');
            $table->string('status', 20);
            $table->timestamps();

            $table->unique(['name', 'sub_org'], 'name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organizations');
    }
};
