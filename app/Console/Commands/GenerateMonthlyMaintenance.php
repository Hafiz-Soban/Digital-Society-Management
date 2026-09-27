<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateMonthlyMaintenance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'maintenance:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically generate monthly maintenance charges for all residents';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $isAutoEnabled = \App\Models\Setting::get('maintenance_auto_enabled', 'disabled');

        if ($isAutoEnabled !== 'enabled') {
            $this->info('Auto monthly maintenance is disabled in settings.');
            return 0;
        }

        $monthlyAmount = \App\Models\Setting::get('maintenance_monthly_amount', 0);

        if ($monthlyAmount <= 0) {
            $this->error('Monthly maintenance amount is not configured or set to 0.');
            return 1;
        }

        $residents = \App\Models\Resident::where('status', 'active')->get();

        $this->info('Generating maintenance for ' . $residents->count() . ' residents...');

        foreach ($residents as $resident) {
            \Illuminate\Support\Facades\DB::transaction(function () use ($resident, $monthlyAmount) {
                if ($resident->advance_balance >= $monthlyAmount) {
                    $resident->advance_balance -= $monthlyAmount;
                } else {
                    $remaining = $monthlyAmount - $resident->advance_balance;
                    $resident->advance_balance = 0;
                    $resident->due_amount += $remaining;
                }
                $resident->save();
            });
        }

        $this->info('Monthly maintenance generation completed successfully.');
        return 0;
    }
}
