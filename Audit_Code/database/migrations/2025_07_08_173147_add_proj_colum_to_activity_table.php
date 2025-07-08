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
        Schema::table('one_link_risk_management', function (Blueprint $table) {
            $table->integer('project_id')->nullable();
            $table->foreign('project_id')->references(['project_id'])->on('projects')->onUpdate('CASCADE')->onDelete('CASCADE');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('one_link_risk_management', function (Blueprint $table) {
            //
        });
    }
};
