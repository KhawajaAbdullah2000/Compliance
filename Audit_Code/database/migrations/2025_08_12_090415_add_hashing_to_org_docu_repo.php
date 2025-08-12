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
        Schema::table('document_repository', function (Blueprint $table) {
            $table->string('content_hash', 64)->nullable();
            $table->unique(['organization_id', 'content_hash'], 'org_doc_hash_unique');
        });
    }

    /**
     * Reverse the migrations.
     */

    public function down(): void
    {
        Schema::table('document_repository', function (Blueprint $table) {
            $table->dropUnique('org_doc_hash_unique');
            $table->dropColumn('content_hash');
        });
    }
};
