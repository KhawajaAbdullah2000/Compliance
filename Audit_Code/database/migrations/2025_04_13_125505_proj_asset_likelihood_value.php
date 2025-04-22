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
        Schema::create('proj_asset_likelihood_value', function (Blueprint $table) {
            $table->id('proj_asset_likelihood_value_id');
            $table->unsignedBigInteger('qualitative_likelihood_risk_confidentiality_selected')->nullable();
            $table->unsignedBigInteger('qualitative_likelihood_risk_integrity_selected')->nullable();
            $table->unsignedBigInteger('qualitative_likelihood_risk_availability_selected')->nullable();

            $table->unsignedBigInteger('quantitative_likelihood_risk_confidentiality_selected')->nullable();
            $table->unsignedBigInteger('quantitative_likelihood_risk_integrity_selected')->nullable();
            $table->unsignedBigInteger('quantitative_likelihood_risk_availability_selected')->nullable();



            $table->integer('project_id')->nullable()->index('projid_sec2_3_1_qa33');
            $table->integer('asset_id')->nullable()->index('asset_id_sec2_3_1_qa32');
            $table->unsignedBigInteger('last_edited_by')->nullable()->index('last_edited_by');
           
            $table->foreign(['asset_id'], 'likefk4')->references(['assessment_id'])->on('iso_sec_2_1')->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->foreign(['last_edited_by'], 'likefk3')->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('SET NULL');

            $table->foreign(['project_id'], 'likefk2')->references(['project_id'])->on('projects')->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->foreign(['qualitative_likelihood_risk_confidentiality_selected'], 'likefk1')->references(['global_likelihood_value_id'])->on('global_likelihood_value')->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->foreign(['qualitative_likelihood_risk_integrity_selected'], 'fk2likefk2')->references(['global_likelihood_value_id'])->on('global_likelihood_value')->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->foreign(['qualitative_likelihood_risk_availability_selected'], 'fk3likefk3')->references(['global_likelihood_value_id'])->on('global_likelihood_value')->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->foreign(['quantitative_likelihood_risk_confidentiality_selected'], 'likefk2qu')->references(['id'])->on('global_quantitative_likelihood_scale')->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->foreign(['quantitative_likelihood_risk_integrity_selected'], 'likefk3qu')->references(['id'])->on('global_quantitative_likelihood_scale')->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->foreign(['quantitative_likelihood_risk_availability_selected'], 'likefk4qu')->references(['id'])->on('global_quantitative_likelihood_scale')->onUpdate('CASCADE')->onDelete('CASCADE');



             $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proj_asset_likelihood_value');
    }
};
