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
        Schema::create('global_likelihood_value', function (Blueprint $table) {
            $table->id('global_likelihood_value_id');
            $table->string('global_likelihood');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
