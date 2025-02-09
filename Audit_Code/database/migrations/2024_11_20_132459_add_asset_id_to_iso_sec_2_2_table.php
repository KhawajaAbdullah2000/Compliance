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
        Schema::table('iso_sec_2_2', function (Blueprint $table) {
            $table->integer('asset_id')->nullable()->index('asset_id');            $table->string('subdomain',100)->nullable();

            $table->foreign('asset_id')
            ->references('assessment_id')
            ->on('iso_sec_2_1')
            ->onDelete('CASCADE'); 
            // Update the unique constraint to include project_id, sub_req, and asset_id
            $table->dropUnique('project_id');
            $table->unique(['project_id', 'sub_req','title_num', 'asset_id','subdomain'], 'project_subreq_asset_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('iso_sec_2_2', function (Blueprint $table) {
            //
        });
    }
};
