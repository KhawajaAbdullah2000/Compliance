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
        Schema::table('iso_sec_2_1', function (Blueprint $table) {

            $table->unsignedBigInteger('service_risk_owner')->nullable();
             $table->unsignedBigInteger('component_risk_owner')->nullable();
              $table->unsignedBigInteger('service_custodian')->nullable();
               $table->unsignedBigInteger('component_custodian')->nullable();

            $table->foreign(['service_risk_owner'])->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('SET NULL');
            
            $table->foreign(['component_risk_owner'])->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('SET NULL');

             $table->foreign(['service_custodian'])->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('SET NULL');

             $table->foreign(['component_custodian'])->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('table_iso_sec_2_1', function (Blueprint $table) {
            //
        });
    }
};
