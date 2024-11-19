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
            $table->dropUnique('project_id_2');

            // Add the new unique constraint
            $table->unique(['project_id', 's_name', 'c_name'], 'project_id_s_name_c_name_unique');
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
