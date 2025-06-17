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
          Schema::create('attachment_for_compliance_project_level', function (Blueprint $table) {
            $table->id();
            $table->string("filename");
          
            $table->integer('project_id')->index('prjid_att_api_comp');

            $table->unsignedBigInteger('uploaded_by')->nullable()->index('last_edited_by');
           
            $table->foreign(['uploaded_by'])->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('SET NULL');

            $table->foreign(['project_id'])->references(['project_id'])->on('projects')->onUpdate('CASCADE')->onDelete('CASCADE');

        
             $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachment_for_compliance_project_level');
    }
};
