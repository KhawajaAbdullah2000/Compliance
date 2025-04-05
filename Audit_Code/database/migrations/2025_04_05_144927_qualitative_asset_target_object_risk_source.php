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
        Schema::create('qualitative_asset_global_target_object_risk_source', function (Blueprint $table) {
            $table->id('qualitative_asset_global_target_object_risk_source_id');
            $table->string('target_objective');
            $table->text('description');
             $table->timestamps();
          

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qualitative_asset_global_target_object_risk_source');
    }
};
