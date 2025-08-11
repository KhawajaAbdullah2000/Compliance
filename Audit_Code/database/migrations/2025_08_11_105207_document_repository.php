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
        Schema::create('document_repository', function (Blueprint $table) {
              $table->bigIncrements('id');
            $table->unsignedBigInteger('organization_id')->index();
            $table->string('name', 100);  
            $table->string('type', 100)->nullable();      
            $table->string('source', 100)->nullable();       
            $table->string("path");
   

            $table->unsignedBigInteger('last_edited_by')->nullable()->index();
            $table->dateTime('last_edited_at')->nullable();

            $table->timestamps();

            $table->foreign('organization_id')->references('id')->on('organizations')->cascadeOnDelete();
            $table->foreign('last_edited_by')->references('id')->on('users')->nullOnDelete()->cascadeOnUpdate();

    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('document_repository', function (Blueprint $table) {
            Schema::dropIfExists('document_repository');
        });
    }
};
