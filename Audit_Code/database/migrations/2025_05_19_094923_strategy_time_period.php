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
         Schema::create('strategy_time_period', function (Blueprint $table) {
           
            $table->id();
            $table->integer('time_period');
    
            $table->integer('project_id')->nullable()->index('projid_internal_audfk1');
            $table->unsignedBigInteger('last_edited_by')->nullable()->index('last_edited_by');
            $table->dateTime('last_edited_at');




           
$table->foreign(['last_edited_by'])->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('SET NULL');



    $table->foreign(['project_id'])->references(['project_id'])->on('projects')->onUpdate('CASCADE')->onDelete('CASCADE');


           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('strategy_time_period');
    }
};
