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
        Schema::create('global_asset_types', function (Blueprint $table) {
            $table->id('asset_type_id');
            $table->unsignedBigInteger('asset_category');
            $table->string('asset_type');
            $table->string('is_manual'); //no or yes
            $table->foreign('asset_category')->references('asset_category_id')->on('global_asset_categories')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('global_asset_categories');

    }
};
