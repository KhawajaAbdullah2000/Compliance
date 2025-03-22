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
        Schema::create('org_assets_categories', function (Blueprint $table) {
            $table->id('org_assets_categories_id');
            $table->unsignedBigInteger('org_id');
            $table->unsignedBigInteger('asset_category_selected');
            $table->foreign('org_id')->references('id')->on('organizations')->onDelete('cascade');
            $table->foreign('asset_category_selected')->references('asset_category_id')->on('global_asset_categories')->onDelete('cascade')->onUpdate('cascade');
            $table->unique(['org_id', 'asset_category_selected'], 'org_asset_category_unique');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('org_assets_categories');
    }
};
