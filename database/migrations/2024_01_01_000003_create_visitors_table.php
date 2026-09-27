<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resident_id')->constrained('residents')->onDelete('cascade');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->string('visitor_name');
            $table->string('visitor_phone')->nullable();
            $table->string('visitor_cnic')->nullable();
            $table->string('vehicle_number')->nullable();
            $table->string('purpose');
            $table->enum('status', ['pending', 'approved', 'denied', 'checked_in', 'checked_out'])->default('pending');
            $table->timestamp('expected_arrival')->nullable();
            $table->timestamp('actual_arrival')->nullable();
            $table->timestamp('departure_time')->nullable();
            $table->string('otp')->nullable();
            $table->timestamp('otp_expires_at')->nullable();
            $table->text('notes')->nullable();
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
};
