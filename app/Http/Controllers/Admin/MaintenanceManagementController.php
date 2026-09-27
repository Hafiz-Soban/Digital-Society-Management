<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Resident;
use App\Models\House;
use App\Models\MaintenancePayment;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MaintenanceManagementController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_monthly_collection' => MaintenancePayment::whereMonth('payment_date', now()->month)->sum('amount'),
            'total_outstanding_dues' => Resident::sum('due_amount'),
            'total_advance_payments' => Resident::sum('advance_balance'),
            'defaulters_count' => Resident::where('due_amount', '>', 0)->count(),
            'high_dues_residents' => Resident::where('due_amount', '>=', 10000)->count(),
        ];

        $recentPayments = MaintenancePayment::with(['resident.user', 'house'])->latest()->take(10)->get();

        return view('admin.maintenance-management.dashboard', compact('stats', 'recentPayments'));
    }

    public function settings()
    {
        $settings = [
            'monthly_amount' => Setting::get('maintenance_monthly_amount', 5000),
            'auto_enabled' => Setting::get('maintenance_auto_enabled', 'disabled'),
            'restriction_enabled' => Setting::get('maintenance_restriction_enabled', 'disabled'),
        ];

        return view('admin.maintenance-management.settings', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'monthly_amount' => 'required|numeric|min:0',
            'auto_enabled' => 'required|in:enabled,disabled',
            'restriction_enabled' => 'required|in:enabled,disabled',
        ]);

        Setting::set('maintenance_monthly_amount', $request->monthly_amount);
        Setting::set('maintenance_auto_enabled', $request->auto_enabled);
        Setting::set('maintenance_restriction_enabled', $request->restriction_enabled);

        return back()->with('success', 'Maintenance settings updated successfully.');
    }

    public function records(Request $request)
    {
        $query = Resident::with(['user', 'house']);

        if ($request->search) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            })->orWhere('resident_id', 'like', '%' . $request->search . '%');
        }

        $residents = $query->paginate(15)->withQueryString();

        return view('admin.maintenance-management.records', compact('residents'));
    }

    public function payments(Request $request)
    {
        $query = MaintenancePayment::with(['resident.user', 'house']);

        if ($request->search) {
            $query->whereHas('resident.user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            })->orWhere('reference_number', 'like', '%' . $request->search . '%');
        }

        $payments = $query->latest()->paginate(15)->withQueryString();

        return view('admin.maintenance-management.payments', compact('payments'));
    }

    public function createPayment()
    {
        $residents = Resident::with(['user', 'house'])->where('status', 'active')->get();
        return view('admin.maintenance-management.create-payment', compact('residents'));
    }

    public function storePayment(Request $request)
    {
        $request->validate([
            'resident_id' => 'required|exists:residents,id',
            'amount' => 'required|numeric|min:1',
            'payment_date' => 'required|date',
            'payment_method' => 'required|string',
            'reference_number' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {
            $resident = Resident::findOrFail($request->resident_id);
            $amount = $request->amount;

            // Reduce due amount first
            if ($resident->due_amount > 0) {
                if ($amount >= $resident->due_amount) {
                    $remaining = $amount - $resident->due_amount;
                    $resident->due_amount = 0;
                    $resident->advance_balance += $remaining;
                } else {
                    $resident->due_amount -= $amount;
                }
            } else {
                $resident->advance_balance += $amount;
            }

            $resident->save();

            MaintenancePayment::create([
                'resident_id' => $resident->id,
                'house_id' => $resident->house_id,
                'amount' => $request->amount,
                'payment_date' => $request->payment_date,
                'payment_method' => $request->payment_method,
                'reference_number' => $request->reference_number,
                'notes' => $request->notes,
            ]);
        });

        return redirect()->route('admin.maintenance-management.payments')
            ->with('success', 'Payment recorded successfully.');
    }
}
