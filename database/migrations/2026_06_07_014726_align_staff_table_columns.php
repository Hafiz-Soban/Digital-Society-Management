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
        Schema::table('staff', function (Blueprint $table) {
            if (Schema::hasColumn('staff', 'name') && !Schema::hasColumn('staff', 'full_name')) {
                $table->renameColumn('name', 'full_name');
            }
            if (Schema::hasColumn('staff', 'phone') && !Schema::hasColumn('staff', 'phone_number')) {
                $table->renameColumn('phone', 'phone_number');
            }
            if (Schema::hasColumn('staff', 'role') && !Schema::hasColumn('staff', 'designation')) {
                $table->renameColumn('role', 'designation');
            }

            if (!Schema::hasColumn('staff', 'employee_id')) {
                $table->string('employee_id')->after('id')->unique()->nullable();
            }
            if (!Schema::hasColumn('staff', 'father_name')) {
                $table->string('father_name')->after('full_name')->nullable();
            }
            if (!Schema::hasColumn('staff', 'alternate_phone')) {
                $table->string('alternate_phone')->after('phone_number')->nullable();
            }
            if (!Schema::hasColumn('staff', 'cnic')) {
                $table->string('cnic')->after('alternate_phone')->unique()->nullable();
            }
            if (!Schema::hasColumn('staff', 'dob')) {
                $table->date('dob')->after('cnic')->nullable();
            }
            if (!Schema::hasColumn('staff', 'gender')) {
                $table->enum('gender', ['male', 'female', 'other'])->after('dob')->default('male');
            }
            if (!Schema::hasColumn('staff', 'photo_path')) {
                $table->string('photo_path')->after('address')->nullable();
            }
            if (!Schema::hasColumn('staff', 'shift_timing')) {
                $table->string('shift_timing')->after('salary')->nullable();
            }
            if (!Schema::hasColumn('staff', 'emergency_name')) {
                $table->string('emergency_name')->after('status')->nullable();
            }
            if (!Schema::hasColumn('staff', 'emergency_phone')) {
                $table->string('emergency_phone')->after('emergency_name')->nullable();
            }
            if (!Schema::hasColumn('staff', 'emergency_relation')) {
                $table->string('emergency_relation')->after('emergency_phone')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No down needed as this is a fix migration
    }
};
