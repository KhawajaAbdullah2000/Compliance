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
         Schema::create('non_standard_custom_data', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id')->nullable();
            $table->string('domain_num')->nullable();
            $table->string('sub_domain_num')->nullable();
            $table->string('sub_req_num')->nullable();

             $table->string('domain_title')->nullable();
            $table->string('sub_domain_title')->nullable();
            $table->string('sub_req_title')->nullable();

            $table->unique(['project_id','domain_num','sub_domain_num','sub_req_num'],'uniq_data_cius');


             $table->foreign(['project_id'])->references(['project_id'])->on('projects')->onUpdate('CASCADE')->onDelete('CASCADE');


           });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('non_standard_custom_data');
    }
};
