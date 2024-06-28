<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->integer('project_id', true);
            $table->string('project_name', 100);
            $table->integer('org_id')->nullable()->index('org_id');
            $table->unsignedBigInteger('created_by')->nullable()->index('created_by');
            $table->date('project_creation_date');
            $table->time('project_creation_time');
            $table->unsignedBigInteger('project_type')->nullable()->index('project_type');
            $table->string('status', 100)->default('Not submitted for approval');
            $table->unsignedBigInteger('status_last_changed_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
};
