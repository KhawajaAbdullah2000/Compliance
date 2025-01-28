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
        Schema::table('iso_sec_2_3_1', function (Blueprint $table) {
            DB::statement("
            ALTER TABLE iso_sec_2_3_1 
            ADD COLUMN risk_score DECIMAL(11,5) 
            GENERATED ALWAYS AS ((threat / 100) * (vulnerability / 100)) STORED
        ");

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('iso_sec_2_3_1', function (Blueprint $table) {
            //
        });
    }
};
