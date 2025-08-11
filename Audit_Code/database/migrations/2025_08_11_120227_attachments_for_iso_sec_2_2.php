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
        Schema::create('iso_sec_2_2_attachments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('iso_sec_2_2_id')->index();
            $table->unsignedBigInteger('document_id')->index();



            $table->unsignedBigInteger('last_edited_by')->nullable()->index();
            $table->dateTime('last_edited_at')->nullable();

            $table->timestamps();
            $table->foreign('document_id')
                ->references('id')->on('document_repository')
                ->cascadeOnDelete();
            $table->foreign('iso_sec_2_2_id')->references('assessment_id')->on('iso_sec_2_2')->cascadeOnDelete();
            $table->foreign('last_edited_by')->references('id')->on('users')->nullOnDelete()->cascadeOnUpdate();

            $table->unique(['iso_sec_2_2_id', 'document_id'], 'iso22_doc_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iso_sec_2_2_attachments');
    }
};
