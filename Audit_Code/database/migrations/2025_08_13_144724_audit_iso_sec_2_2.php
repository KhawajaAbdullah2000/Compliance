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
         Schema::create('audit_iso_sec_2_2', function (Blueprint $table) {
            $table->integer('assessment_id', true);
            $table->integer('project_id')->nullable()->index('project_id_2');
            $table->string('title_num',100)->nullable();
            $table->string('sub_req', 100)->nullable();
            $table->string('comp_status', 30)->nullable();
            $table->longText('comments')->nullable();
            $table->string('attachment', 1000)->nullable();
             $table->string('applicability')->nullable();
            $table->longText('treatment_action')->nullable();
            $table->date('treatment_target_date')->nullable();
            $table->date('treatment_comp_date')->nullable();
            $table->unsignedBigInteger('responsibility_for_treatment')->nullable();
            $table->date('acceptance_actual_date')->nullable();
            $table->unsignedBigInteger('last_edited_by')->nullable()->index('last_edited_by');
            $table->dateTime('last_edited_at');

              $table->foreign(['last_edited_by'], 'aud_iso_2_2edit')->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('SET NULL');

                $table->foreign(['responsibility_for_treatment'], 'audit_resp_sec2_2')->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('SET NULL');

            $table->foreign(['project_id'])->references(['project_id'])->on('projects')->onUpdate('CASCADE')->onDelete('CASCADE');
          
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_iso_sec_2_2');
    }
};
