<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('society_health_scores', function (Blueprint $table) {
            $table->id();
            $table->date('score_month');
            $table->enum('mode', ['automatic', 'manual'])->default('automatic');
            $table->decimal('security_score', 5, 2)->default(0);
            $table->decimal('complaint_score', 5, 2)->default(0);
            $table->decimal('maintenance_score', 5, 2)->default(0);
            $table->decimal('emergency_score', 5, 2)->default(0);
            $table->decimal('overall_score', 5, 2)->default(0);
            $table->string('grade')->nullable();
            $table->json('details')->nullable();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->unique('score_month');
        });

        Schema::create('resident_rankings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resident_id')->constrained('residents')->cascadeOnDelete();
            $table->date('score_month');
            $table->enum('mode', ['automatic', 'manual'])->default('automatic');
            $table->unsignedInteger('score')->default(0);
            $table->string('badge')->nullable();
            $table->unsignedInteger('ranking_position')->nullable();
            $table->json('details')->nullable();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('calculated_at')->nullable();
            $table->timestamps();

            $table->unique('resident_id');
        });

        Schema::create('resident_badge_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resident_id')->constrained('residents')->cascadeOnDelete();
            $table->date('score_month');
            $table->unsignedInteger('score')->default(0);
            $table->string('badge')->nullable();
            $table->unsignedInteger('ranking_position')->nullable();
            $table->json('reasons')->nullable();
            $table->json('details')->nullable();
            $table->timestamp('notified_at')->nullable();
            $table->timestamps();

            $table->unique(['resident_id', 'score_month']);
        });

        Schema::table('notifications', function (Blueprint $table) {
            if (!Schema::hasColumn('notifications', 'data')) {
                $table->json('data')->nullable()->after('link');
            }
        });
    }

    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            if (Schema::hasColumn('notifications', 'data')) {
                $table->dropColumn('data');
            }
        });

        Schema::dropIfExists('resident_badge_histories');
        Schema::dropIfExists('resident_rankings');
        Schema::dropIfExists('society_health_scores');
    }
};
