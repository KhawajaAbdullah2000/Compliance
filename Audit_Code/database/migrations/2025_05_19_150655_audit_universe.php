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
         Schema::create('audit_universe', function (Blueprint $table) {
           
            $table->id();
            $table->unsignedBigInteger('risk_based_plan_audit_id');
            $table->integer('project_id')->nullable()->index('prj_risk_base_fork1');
            $table->string('name');
            $table->date('planned_start')->nullable();
            $table->date('planned_end')->nullable();
            $table->date('actual_start')->nullable();
            $table->date('actual_end')->nullable();
            $table->unsignedBigInteger('last_edited_by')->nullable()->index('last_edited_by');
            $table->unsignedBigInteger('auditor')->nullable()->index('auditor');
            $table->unsignedBigInteger('approver')->nullable()->index('approver');
           
            $table->dateTime('last_edited_at');

            $table->foreign('risk_based_plan_audit_id')->references('id')->on('risk_based_plan_audit')->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->foreign(['last_edited_by'])->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('SET NULL');

             $table->foreign(['auditor'])->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('SET NULL');

             $table->foreign(['approver'])->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('SET NULL');


            $table->foreign(['project_id'])->references(['project_id'])->on('projects')->onUpdate('CASCADE')->onDelete('CASCADE');


           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_universe');
    }
};
