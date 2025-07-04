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
        Schema::create('units', function (Blueprint $table) {
    $table->bigIncrements('id');
    $table->unsignedBigInteger('department_id');
    $table->string('name', 100);
    $table->timestamps();

    $table->foreign('department_id')
        ->references('id')->on('departments')
        ->onUpdate('CASCADE')
        ->onDelete('CASCADE');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
