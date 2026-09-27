<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Change 'open' status to 'pending' in complaints table
        DB::statement("ALTER TABLE complaints MODIFY COLUMN status ENUM('pending','in_progress','resolved','closed','escalated') NOT NULL DEFAULT 'pending'");

        // Update any existing 'open' records to 'pending'
        DB::statement("UPDATE complaints SET status = 'pending' WHERE status = 'open'");
    }

    public function down(): void
    {
        DB::statement("UPDATE complaints SET status = 'open' WHERE status = 'pending'");
        DB::statement("ALTER TABLE complaints MODIFY COLUMN status ENUM('open','in_progress','resolved','closed','escalated') NOT NULL DEFAULT 'open'");
    }
};
