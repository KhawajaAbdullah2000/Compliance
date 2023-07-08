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
        Schema::create('project_details', function (Blueprint $table) {
           // $table->id();
           $table->string('project_code',100);
           $table->unsignedBigInteger('assigned_enduser')->nullable();
           $table->unsignedBigInteger('last_changed_by')->nullable();
           $table->unsignedBigInteger('status_last_changed_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_details');
    }
};
