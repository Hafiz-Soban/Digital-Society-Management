<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('houses', function (Blueprint $table) {
            $table->id();
            $table->string('house_number')->unique();
            $table->string('block')->nullable();
            $table->string('floor')->nullable();
            $table->enum('type', ['apartment', 'villa', 'townhouse', 'studio'])->default('apartment');
            $table->integer('bedrooms')->default(1);
            $table->decimal('area_sqft', 8, 2)->nullable();
            $table->decimal('monthly_maintenance', 10, 2)->default(0);
            $table->enum('status', ['occupied', 'vacant', 'under_maintenance'])->default('vacant');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('houses');
    }
};
