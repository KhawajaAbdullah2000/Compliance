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
            $table->string('g_name', 100)->nullable()->change();
            $table->string('name', 100)->nullable()->change();
            $table->string('owner_dept', 300)->nullable()->change();
            $table->string('physical_loc', 300)->nullable()->change();
            $table->string('logical_loc', 300)->nullable()->change();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('iso_sec_2_1', function (Blueprint $table) {
            //
        });
    }
};
