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
        
        Schema::table('one_link_risk_record', function (Blueprint $table) {

            $table->longText('comments')->nullable();
       
    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       
    }
};
