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
        Schema::table('audit_projects', function (Blueprint $table) {
              $table->unsignedBigInteger('status_changed_by')->nullable()->index('status_changed_by');

            $table->foreign(['status_changed_by'])->references(['id'])->on('users')->onUpdate('SET NULL')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('audit_projects', function (Blueprint $table) {
            //
        });
    }
};
