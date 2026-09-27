<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('houses', function (Blueprint $table) {
            $table->string('owner_name')->nullable()->after('floor');
            $table->string('owner_cnic')->nullable()->after('owner_name');
            $table->string('owner_phone')->nullable()->after('owner_cnic');
        });
    }

    public function down(): void
    {
        Schema::table('houses', function (Blueprint $table) {
            $table->dropColumn(['owner_name', 'owner_cnic', 'owner_phone']);
        });
    }
};
