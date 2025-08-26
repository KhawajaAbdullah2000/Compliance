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
        Schema::create('audit_trail_for_services',function(Blueprint $table){
            $table->id();
            $table->integer('asset_id')->nullable();
            $table->integer('project_id')->nullable();
            $table->unsignedBigInteger('last_edited_by')->nullable();
            $table->string('operation_type');
            $table->string('g_name', 100)->nullable();
            $table->string('name', 100)->nullable();
            $table->string('c_name', 100)->nullable();
            $table->string('s_name', 100)->nullable();
            $table->string('owner_dept', 300)->nullable();
            $table->string('physical_loc', 300)->nullable();
            $table->string('logical_loc', 300)->nullable();
            $table->integer('risk_confidentiality')->nullable();
            $table->integer('risk_integrity')->nullable();
            $table->integer('risk_availability')->nullable();
            $table->dateTime('performed_at');
            $table->foreign(['last_edited_by'])->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('SET NULL');
            $table->foreign(['project_id'])->references(['project_id'])->on('projects')->onUpdate('CASCADE')->onDelete('SET NULL');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
