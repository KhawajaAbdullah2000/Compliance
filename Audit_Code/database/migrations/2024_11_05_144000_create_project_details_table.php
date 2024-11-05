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
        Schema::create('project_details', function (Blueprint $table) {
            $table->integer('project_code')->nullable()->index('project_code');
            $table->unsignedBigInteger('assigned_enduser')->nullable()->index('assigned_enduser');
            $table->longText('project_permissions');
            $table->timestamps();

            $table->index(['project_code'], 'project_code_2');
            $table->unique(['project_code', 'assigned_enduser'], 'project_code_3');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_details');
    }
};
