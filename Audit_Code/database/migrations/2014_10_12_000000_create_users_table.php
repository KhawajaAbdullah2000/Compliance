<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('organization_name',100)->nullable();
            $table->string('organization_sub-org',100)->nullable();
            $table->string('first_name',100);
            $table->string('last_name',100);
            $table->string('email')->unique();
            $table->string('telephone',100);
            $table->string('address',100);
            $table->string('city',100);
            $table->string('state',100);
            $table->string('country',100);
            $table->integer('zip_code',false,false);
            $table->string('password',100);
            $table->string('2FA',3);
            $table->unsignedBigInteger('privilege_id')->nullable();
            $table->string('status',20);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
