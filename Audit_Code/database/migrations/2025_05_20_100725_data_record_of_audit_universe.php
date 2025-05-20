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
         Schema::create('data_record_audit_universe', function (Blueprint $table) {
           
            $table->id();
            $table->unsignedBigInteger('audit_universe_id');
            $table->string('data_record_name');
            $table->string('data_record_approach')->nullable();
            $table->string('data_record_sampling')->nullable();

       
            $table->unsignedBigInteger('last_edited_by')->nullable()->index('last_edited_by');
           
            $table->dateTime('last_edited_at');


            $table->foreign(['last_edited_by'])->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('SET NULL');

           

           
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_record_audit_universe');
    }
};
