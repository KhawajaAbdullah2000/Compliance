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
        Schema::create('org_quantitavie_consequence_scale', function (Blueprint $table) {
            $table->id('org_quantitavie_consequence_scale_id');
            $table->unsignedBigInteger('org_id');
            $table->unsignedBigInteger('project_type_id');
             $table->unsignedBigInteger('currency_selected');
             $table->string('log_expression');
             $table->integer('scale');
             $table->integer('consequence_amount')->nullable();
             $table->foreign('org_id')->references('id')->on('organizations')->onDelete('cascade');
             $table->foreign('project_type_id')->references('id')->on('project_types')->onDelete('cascade');
             $table->foreign('currency_selected')->references('global_currency_id')->on('global_currency')->onDelete('cascade')->onUpdate('cascade');

             $table->unique(['org_id','project_type_id','scale','log_expression'], 'uq_org_qcs_orgid_scale_logexpr');

             $table->timestamps();
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
