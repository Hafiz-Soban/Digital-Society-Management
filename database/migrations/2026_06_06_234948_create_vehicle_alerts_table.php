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
        Schema::create('vehicle_alerts', function (Blueprint $table) {
            $table->id();
            $table->string('vehicle_number');
            $table->string('alert_type');
            $table->text('reason');
            $table->foreignId('security_guard_id')->constrained('users');
            $table->enum('status', ['pending', 'resolved'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_alerts');
    }
};
