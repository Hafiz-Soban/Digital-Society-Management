<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('domestic_staff', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resident_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('cnic', 25)->nullable();
            $table->string('mobile', 25)->nullable();
            $table->enum('staff_type', [
                'maid',
                'driver',
                'cook',
                'electrician',
                'gardener',
                'plumber',
                'security_guard',
                'other',
            ]);
            $table->date('joining_date')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->text('address')->nullable();
            $table->string('emergency_contact', 100)->nullable();
            $table->string('profile_photo_path')->nullable();
            $table->uuid('qr_token')->unique();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['resident_id', 'name']);
            $table->index(['resident_id', 'staff_type']);
            $table->index(['resident_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('domestic_staff');
    }
};

