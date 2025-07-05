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
        Schema::create('one_link_risk_record', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('org_id')->nullable(); // optional if needed later
            $table->unsignedBigInteger('department_id')->nullable();
            $table->integer('project_id')->nullable();
            $table->unsignedBigInteger('unit_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('cycle_id');
            $table->unsignedBigInteger('sub_process_id');

            $table->date('risk_identification_date')->nullable();
            $table->date('risk_reassessment_date')->nullable();

            $table->longText('risk_description')->nullable();
            $table->string('erm_risk_classification')->nullable();

             $table->string('op_loss_event_type_one')->nullable();
              $table->string('op_loss_event_type_two')->nullable();
                $table->unsignedBigInteger('risk_owner')->nullable();

            

          

         
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('project_id')->references(['project_id'])->on('projects')->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('one_link_sub_entities')->onDelete('cascade');
            $table->foreign('cycle_id')->references('id')->on('one_link_sub_entities')->onDelete('cascade');
            $table->foreign('sub_process_id')->references('id')->on('one_link_sub_entities')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('risk_owner')->references('id')->on('users')->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('one_link_risk_record');
    }
};
