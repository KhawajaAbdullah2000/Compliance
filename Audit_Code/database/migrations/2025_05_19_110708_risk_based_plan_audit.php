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
        Schema::create('risk_based_plan_audit', function (Blueprint $table) {
           
            $table->id();
            $table->unsignedBigInteger('organization_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->integer('project_id')->nullable()->index('projid_riskbasfk1');
            $table->unsignedBigInteger('last_edited_by')->nullable()->index('last_edited_by');
            $table->dateTime('last_edited_at');

            $table->integer('strategy_time_period')->nullable();
            $table->string('audit_approach')->nullable();
            $table->string('sampling_methodology')->nullable();
            $table->longText('risk_affecting')->nullable();
            $table->longText('risk_mitigation')->nullable();

            $table->date('audit_started')->nullable();
            $table->date('audit_ended')->nullable();


            $table->longText('inclusions_in_scope')->nullable();
            $table->longText('exclusions_in_scope')->nullable();
            $table->longText('persons_interviewed')->nullable();
            $table->longText('documents_reviewed')->nullable();
            $table->longText('processes_observed')->nullable();
            $table->longText('artefacts_examined')->nullable();
            $table->longText('requirements_status_compliance')->nullable();



           
            $table->foreign(['last_edited_by'])->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('SET NULL');



            $table->foreign('organization_id')
                  ->references('id')
                  ->on('organizations')
                  ->onDelete('set null')
                  ->onUpdate('cascade');

            // Foreign Key to Departments
        
            $table->foreign('department_id')
                  ->references('id')
                  ->on('departments')
                  ->onDelete('set null')
                  ->onUpdate('cascade');

    $table->foreign(['project_id'])->references(['project_id'])->on('projects')->onUpdate('CASCADE')->onDelete('CASCADE');


           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('risk_based_plan_audit');
    }
};
