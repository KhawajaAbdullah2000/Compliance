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
        Schema::create('threat_desc_for_global_threats', function (Blueprint $table) {
            $table->id('threat_desc_for_global_threats_id');
            $table->string('threat_description');
            $table->unsignedBigInteger('global_threat'); 

            $table->foreign('global_threat','gloablthfk1')->references('global_threat_posed_by_risk_source_id')->on('global_threat_posed_by_risk_source')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('threat_desc_for_global_threats');

    }
};
