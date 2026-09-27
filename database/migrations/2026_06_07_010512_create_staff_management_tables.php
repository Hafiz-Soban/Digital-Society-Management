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
        if (!Schema::hasTable('staff')) {
            Schema::create('staff', function (Blueprint $table) {
                $table->id();
                $table->string('employee_id')->unique();
                $table->string('full_name');
                $table->string('father_name');
                $table->string('email')->nullable();
                $table->string('phone_number');
                $table->string('alternate_phone')->nullable();
                $table->string('cnic')->unique();
                $table->date('dob');
                $table->enum('gender', ['male', 'female', 'other']);
                $table->text('address');
                $table->string('photo_path')->nullable();
                $table->string('role');
                $table->date('joining_date');
                $table->decimal('salary', 15, 2);
                $table->string('shift_timing');
                $table->enum('status', ['active', 'inactive'])->default('active');
                $table->string('emergency_name');
                $table->string('emergency_phone');
                $table->string('emergency_relation');
                $table->timestamps();
                $table->softDeletes();
            });
        }

        if (!Schema::hasTable('staff_attendance')) {
            Schema::create('staff_attendance', function (Blueprint $table) {
                $table->id();
                $table->foreignId('staff_id')->constrained('staff')->onDelete('cascade');
                $table->date('date');
                $table->time('check_in')->nullable();
                $table->time('check_out')->nullable();
                $table->enum('status', ['present', 'absent', 'leave']);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('staff_salaries')) {
            Schema::create('staff_salaries', function (Blueprint $table) {
                $table->id();
                $table->foreignId('staff_id')->constrained('staff')->onDelete('cascade');
                $table->decimal('amount', 15, 2);
                $table->string('month'); // e.g., "June 2026"
                $table->date('payment_date')->nullable();
                $table->enum('status', ['paid', 'pending'])->default('pending');
                $table->timestamps();
                $table->softDeletes();
            });
        }

        if (!Schema::hasTable('staff_advances')) {
            Schema::create('staff_advances', function (Blueprint $table) {
                $table->id();
                $table->foreignId('staff_id')->constrained('staff')->onDelete('cascade');
                $table->decimal('amount', 15, 2);
                $table->date('advance_date');
                $table->string('reason')->nullable();
                $table->text('notes')->nullable();
                $table->foreignId('approved_by')->constrained('users');
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_advances');
        Schema::dropIfExists('staff_salaries');
        Schema::dropIfExists('staff_attendance');
        Schema::dropIfExists('staff');
    }
};
