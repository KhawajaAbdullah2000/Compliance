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
        Schema::create('party_scenarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('party_type');
            $table->integer('project_id')->nullable()->index('projid_party_fk');

            $table->string('risk_type');
            $table->string('title');
              $table->longText('scenario')->nullable();
              $table->dateTime('last_edited_at');


            $table->unsignedBigInteger('last_edited_by')->nullable()->index('last_edited_by');
           
            $table->foreign(['last_edited_by'], 'lastEdpar_scene_fk2')->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('SET NULL');

            $table->foreign(['project_id'], 'projid_a_parscefk1')->references(['project_id'])->on('projects')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('party_type')->references('id')->on('party')->onDelete('Cascade')->onUpdate('Cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('party_scenarios');
    }
};
