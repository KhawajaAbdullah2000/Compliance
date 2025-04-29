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
        Schema::create('data_catalog', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id')->nullable()->index('projid_dg1');
            $table->unsignedBigInteger('last_edited_by')->nullable()->index('last_edited_by');

            $table->string('name',100);
            $table->string('data_source',100)->nullable();
            $table->string('data_type',100)->nullable();
            $table->string('data_definition',100)->nullable();
            $table->string('owner_dept',100)->nullable();
            $table->string('user_dept',100)->nullable();
            $table->string('governance_policy',100)->nullable();
            $table->string('confidentiality_tag',100)->nullable();
            $table->string('integrity_tag',100)->nullable();
            $table->string('availability_tag',100)->nullable();
            $table->integer('quality_score')->nullable();
            

            $table->foreign(['project_id'], 'fkdatac2')->references(['project_id'])->on('projects')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['last_edited_by'], 'dccu1')->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('SET NULL');
            $table->dateTime('last_edited_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_catalog');
    }
};
