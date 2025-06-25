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
        
        Schema::create('one_link_sub_entities', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('sub_entity_type'); // e.g., Function, Product, etc.

            $table->unsignedBigInteger('org_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();

            $table->timestamps();

            // Foreign key constraints
            $table->foreign('org_id')->references('id')->on('organizations')->onDelete('set null');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
          Schema::dropIfExists('one_link_sub_entities');
    }
};
