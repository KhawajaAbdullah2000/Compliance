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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('org_id')->nullable()->index('org_id');
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('national_id')->nullable();
            $table->string('email')->unique();
            $table->string('telephone', 100);
            $table->string('address', 100);
            $table->string('city', 100);
            $table->string('state', 100);
            $table->string('country', 100);
            $table->integer('zip_code');
            $table->string('password');
            $table->string('2FA', 3);
            $table->unsignedBigInteger('privilege_id')->nullable();
            $table->string('status', 20);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
