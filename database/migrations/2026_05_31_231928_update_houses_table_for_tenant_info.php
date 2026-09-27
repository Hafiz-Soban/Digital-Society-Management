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
        Schema::table('houses', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->enum('is_rented', ['yes', 'no'])->default('no')->after('status');
            $table->string('tenant_name')->nullable()->after('is_rented');
            $table->string('tenant_father_name')->nullable()->after('tenant_name');
            $table->string('tenant_cnic')->nullable()->after('tenant_father_name');
            $table->string('tenant_contact')->nullable()->after('tenant_cnic');
            $table->string('rent_agreement_path')->nullable()->after('tenant_contact');
            $table->enum('rent_agreement_status', ['issued', 'not_issued'])->nullable()->after('rent_agreement_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('houses', function (Blueprint $table) {
            $table->enum('type', ['apartment', 'villa', 'townhouse', 'studio'])->default('apartment')->after('floor');
            $table->dropColumn([
                'is_rented',
                'tenant_name',
                'tenant_father_name',
                'tenant_cnic',
                'tenant_contact',
                'rent_agreement_path',
                'rent_agreement_status'
            ]);
        });
    }
};
