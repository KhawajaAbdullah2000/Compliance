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
        Schema::create('organizations', function (Blueprint $table) {
          //  $table->id();
          $table->string('name',100);
          $table->string('type',100);
          $table->string('sub-org',100);
          $table->string('country',100);
          $table->string('state',100);
          $table->string('city',100);
          $table->integer('zip_code',false,false);
          $table->string('address',100);
          $table->string('record_created_by',100);
          $table->date('record_creation_date');
          $table->time('record_creation_time');
          $table->string('status',20);
          $table->primary(['name', 'sub-org']);
          $table->timestamps();

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizations');
    }
};
