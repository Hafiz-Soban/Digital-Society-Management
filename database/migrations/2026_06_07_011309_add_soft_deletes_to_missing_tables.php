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
        Schema::table('visitors', function (Blueprint $table) {
            if (!Schema::hasColumn('visitors', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        Schema::table('security_logs', function (Blueprint $table) {
            if (!Schema::hasColumn('security_logs', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visitors', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('security_logs', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
