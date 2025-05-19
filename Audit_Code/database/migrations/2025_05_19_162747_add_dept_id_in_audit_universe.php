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
        Schema::table('audit_universe', function (Blueprint $table) {
            $table->unsignedBigInteger('dept_id');

            $table->foreign('dept_id')->references('id')->on('departments')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('audit_universe', function (Blueprint $table) {
            $table->dropColumn('dept_id');
        });
    }
};
