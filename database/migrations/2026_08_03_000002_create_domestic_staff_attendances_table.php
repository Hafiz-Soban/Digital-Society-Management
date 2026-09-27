<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('domestic_staff_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('domestic_staff_id')->constrained('domestic_staff')->cascadeOnDelete();
            $table->date('attendance_date');
            $table->enum('status', ['present', 'absent', 'leave']);
            $table->time('check_in_time')->nullable();
            $table->time('check_out_time')->nullable();
            $table->timestamps();

            $table->unique(['domestic_staff_id', 'attendance_date'], 'ds_attendance_unique');
            $table->index(['attendance_date', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('domestic_staff_attendances');
    }
};
