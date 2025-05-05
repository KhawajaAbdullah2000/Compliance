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
        Schema::create('dama_kpi', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id')->nullable()->index('projid_dg1');

            $table->integer('policy_num');

            $table->integer('kpi_num'); //$index in form

            $table->string('measured_value',100)->nullable();
            $table->date('measurement_date')->nullable();
            $table->string('target_value')->nullable();
            $table->date('target_date')->nullable();
            $table->unsignedBigInteger('responsible')->nullable()->index('responsible');

        
            $table->unsignedBigInteger('last_edited_by')->nullable()->index('last_edited_by');

            $table->foreign(['project_id'], 'fkdatdama1')->references(['project_id'])->on('projects')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['last_edited_by'], 'damafk2u1')->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('SET NULL');
            $table->foreign(['responsible'], 'damafk3res')->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('SET NULL');

            $table->dateTime('last_edited_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dama_kpi');
    }
};
