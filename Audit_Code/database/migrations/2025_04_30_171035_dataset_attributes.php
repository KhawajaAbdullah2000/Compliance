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
        Schema::create('dataset_attributes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dataset_id')->index();
            $table->string('attribute_name', 100); // e.g. 'Employee Name'
            $table->enum('attribute_type', ['string', 'date']);
            $table->text('attribute_value')->nullable(); // store as string (dates can be parsed)
            
            $table->foreign('dataset_id')->references('id')->on('datasets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dataset_attributes');
    }
};
