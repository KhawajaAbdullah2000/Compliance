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
        Schema::create('party', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id')->nullable()->index('projid_party_fk');
            $table->string('party_name');
            $table->string('party_type');
            $table->string('party_category');
            $table->unsignedBigInteger('last_edited_by')->nullable()->index('last_edited_by');
           
            $table->foreign(['last_edited_by'], 'lastEdparty_fk3')->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('SET NULL');

            $table->foreign(['project_id'], 'projid_a_partyfk2')->references(['project_id'])->on('projects')->onUpdate('CASCADE')->onDelete('CASCADE');
             
            $table->dateTime('last_edited_at');
          
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('party');
    }
};
