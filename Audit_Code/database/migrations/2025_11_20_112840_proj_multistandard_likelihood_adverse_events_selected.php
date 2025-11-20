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
        Schema::create('proj_multistandard_likelihood_adverse_event_selected', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('likelihood_adverse_event_selected');

            $table->integer('project_id')->nullable()->index('proj_id_mul_adv');
            $table->integer('asset_id')->nullable()->index('asset_id_mul_adv');
            $table->unsignedBigInteger('last_edited_by')->nullable()->index('ed_mul_adv');

            $table->foreign('asset_id', 'ass_mul_adv')
                ->references('assessment_id')
                ->on('iso_sec_2_1')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->foreign('last_edited_by', 'ed_mul_adv')
                ->references('id')
                ->on('users')
                ->onUpdate('CASCADE')
                ->onDelete('SET NULL');

            $table->foreign('project_id', 'proj_mul_adv')
                ->references('project_id')
                ->on('projects')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->foreign('likelihood_adverse_event_selected', 'sel_mul_adv')
                ->references('id')
                ->on('global_multistandard_likelihood_adverse_events')
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
