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
        Schema::create('data_record_attachments', function (Blueprint $table) {
           
            $table->id();
            $table->unsignedBigInteger('data_record_id');
            $table->string('attachment');

       
            $table->unsignedBigInteger('last_edited_by')->nullable()->index('last_edited_by');
           
            $table->dateTime('last_edited_at');


            $table->foreign(['last_edited_by'])->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('SET NULL');

           $table->foreign('data_record_id')->references('id')->on('data_record_audit_universe')->onUpdate('CASCADE')->onDelete('CASCADE');

           
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_record_attachments');
    }
};
