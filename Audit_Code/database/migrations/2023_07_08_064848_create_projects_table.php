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
        Schema::create('projects', function (Blueprint $table) {
            //$table->id();
            $table->string('project_code',100);
            $table->string('project_name',100);
            $table->string('user_email',100);
            $table->date('project_creation_date');
            $table->time('project_creation_time');
            $table->unsignedBigInteger('project_type');
            $table->string('status',100);
            $table->string('project_owner',100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
