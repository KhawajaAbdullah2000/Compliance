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
         Schema::create('audit_projects', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('project_name', 100);
            $table->unsignedBigInteger('org_id')->nullable()->index('org_id');
            $table->unsignedBigInteger('created_by')->nullable()->index('created_by');
            $table->date('project_creation_date')->nullable();
            $table->time('project_creation_time')->nullable();
            $table->unsignedBigInteger('project_type')->nullable()->index('project_type');
            $table->string('status', 100)->default('Not submitted for approval');
            $table->unsignedBigInteger('status_last_changed_by')->nullable();
            $table->unsignedBigInteger('dept_id')->nullable()->index('dept_id');
            $table->timestamps();
            $table->datetime('deleted_at')->nullable();
            $table->datetime('status_changed_at')->nullable();
            
             $table->foreign('dept_id')
          ->references('id')
          ->on('departments')
          ->onUpdate('cascade')
          ->onDelete('set null');

           $table->foreign(['created_by'])->references(['id'])->on('users')->onUpdate('SET NULL')->onDelete('SET NULL');

            $table->foreign(['org_id'])->references(['id'])->on('organizations')->onUpdate('SET NULL')->onDelete('SET NULL');

            $table->foreign(['project_type'])->references(['id'])->on('project_types')->onUpdate('SET NULL')->onDelete('SET NULL');
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
