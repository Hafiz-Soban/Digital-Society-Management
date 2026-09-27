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
        Schema::table('notices', function (Blueprint $table) {
            // First, modify target_audience if needed or add new fields
            $table->string('target_type')->default('all')->after('target_audience'); // all, block, house, residents, security, staff, custom
            $table->json('target_blocks')->nullable()->after('target_type');
            $table->json('target_houses')->nullable()->after('target_blocks');
            $table->json('target_users')->nullable()->after('target_houses');
            $table->unsignedInteger('delivery_count')->default(0)->after('target_users');
            $table->unsignedInteger('read_count')->default(0)->after('delivery_count');
        });

        // Create notice_reads table for tracking individual reads
        Schema::create('notice_reads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('notice_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            $table->unique(['notice_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notice_reads');
        
        Schema::table('notices', function (Blueprint $table) {
            $table->dropColumn([
                'target_type', 
                'target_blocks', 
                'target_houses', 
                'target_users', 
                'delivery_count', 
                'read_count'
            ]);
        });
    }
};
