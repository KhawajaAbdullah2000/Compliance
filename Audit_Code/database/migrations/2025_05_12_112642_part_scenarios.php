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
            $table->string('risk_type');
            $table->longText('scenario');

  
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
