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
        // No schema changes needed, just adding a default setting
        \App\Models\Setting::updateOrCreate(
            ['key' => 'maintenance_restriction_enabled'],
            ['value' => '0']
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \App\Models\Setting::where('key', 'maintenance_restriction_enabled')->delete();
    }
};
