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
        if (!Schema::hasTable('expenses')) {
            Schema::create('expenses', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('category');
                $table->decimal('amount', 15, 2);
                $table->date('date');
                $table->string('reference_no')->nullable();
                $table->text('description')->nullable();
                $table->string('bill_path')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        } else {
            Schema::table('expenses', function (Blueprint $table) {
                if (!Schema::hasColumn('expenses', 'bill_path')) {
                    $table->string('bill_path')->after('description')->nullable();
                }
                if (!Schema::hasColumn('expenses', 'reference_no') && Schema::hasColumn('expenses', 'reference_number')) {
                    $table->renameColumn('reference_number', 'reference_no');
                }
            });
        }

        if (!Schema::hasTable('expense_budgets')) {
            Schema::create('expense_budgets', function (Blueprint $table) {
                $table->id();
                $table->string('month'); // e.g. "June 2026"
                $table->decimal('amount', 15, 2);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Not dropping tables to preserve data
    }
};
