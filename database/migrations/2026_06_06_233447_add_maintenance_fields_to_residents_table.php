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
        Schema::table('residents', function (Blueprint $table) {
            if (!Schema::hasColumn('residents', 'due_amount')) {
                $table->decimal('due_amount', 15, 2)->default(0)->after('status');
            }
            if (!Schema::hasColumn('residents', 'advance_balance')) {
                $table->decimal('advance_balance', 15, 2)->default(0)->after('due_amount');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('residents', function (Blueprint $table) {
            $table->dropColumn(['due_amount', 'advance_balance']);
        });
    }
};
