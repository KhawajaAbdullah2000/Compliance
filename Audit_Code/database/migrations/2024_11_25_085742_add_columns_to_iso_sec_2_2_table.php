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
        Schema::table('iso_sec_2_2', function (Blueprint $table) {
            $table->string('treatment_action', 1000)->nullable();
            $table->date('treatment_target_date')->nullable();
            $table->date('treatment_comp_date')->nullable();
            $table->unsignedBigInteger('responsibility_for_treatment')->nullable();
            $table->date('acceptance_actual_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('iso_sec_2_2', function (Blueprint $table) {
            //
        });
    }
};
