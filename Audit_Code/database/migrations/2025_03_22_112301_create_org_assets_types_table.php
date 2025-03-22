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
        Schema::create('org_assets_types', function (Blueprint $table) {
            $table->id('org_assets_types_id');
            $table->unsignedBigInteger('org_id');
            $table->unsignedBigInteger('asset_type_selected');
            $table->foreign('org_id')->references('id')->on('organizations')->onDelete('cascade');
            $table->foreign('asset_type_selected')->references('asset_type_id')->on('global_asset_types')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('org_assets_types');
    }
};
