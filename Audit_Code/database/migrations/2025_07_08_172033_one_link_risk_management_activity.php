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
        Schema::create('one_link_risk_management', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('responsible_team');
    
            $table->date('scheduled_date')->nullable();
        
 
            $table->string('activity_name')->nullable();

            $table->string('activity_type')->nullable();
            $table->string('frequency')->nullable();
            $table->string('completion_status')->nullable();
            $table->longText('comments')->nullable();
              

            
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            // Foreign keys

            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('responsible_team')->references('id')->on('units')->onDelete('cascade');
           

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('one_link_risk_management');
    }
};
