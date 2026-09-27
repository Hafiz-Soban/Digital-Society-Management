<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
<<<<<<< HEAD
use App\Models\ExpenseBudget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $query = Expense::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', "%{$request->search}%")
                  ->orWhere('reference_no', 'like', "%{$request->search}%");
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('month') && $request->filled('year')) {
            $query->whereMonth('date', $request->month)
                  ->whereYear('date', $request->year);
        }

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('date', [$request->from, $request->to]);
        }

        $expenses = $query->latest('date')->paginate(15);
        $categories = Expense::distinct()->pluck('category');
        $defaultCategories = [
            'Electricity Bill', 'Water Bill', 'Gas Bill', 'Internet',
            'Staff Salary', 'Maintenance', 'Security', 'Cleaning',
            'Repair Work', 'Office Expense', 'Other'
        ];
        
        // Merge with existing categories from DB
        $allCategories = $categories->merge($defaultCategories)->unique()->sort();

        // Dashboard stats
        $currentMonth = now()->format('F Y');
        $totalExpensesMonth = Expense::whereMonth('date', now()->month)
                                     ->whereYear('date', now()->year)
                                     ->sum('amount');
        $totalExpensesYear = Expense::whereYear('date', now()->year)
                                    ->sum('amount');
        $highestCategory = Expense::select('category', \DB::raw('SUM(amount) as total'))
                                   ->groupBy('category')
                                   ->orderByDesc('total')
                                   ->first();
        $totalEntries = Expense::count();

        // Budget logic
        $budget = ExpenseBudget::where('month', $currentMonth)->first();
        $budgetAmount = $budget ? $budget->amount : 0;
        $remainingBudget = $budgetAmount - $totalExpensesMonth;

        return view('admin.expenses.index', compact(
            'expenses', 'allCategories', 'totalExpensesMonth', 
            'totalExpensesYear', 'highestCategory', 'totalEntries',
            'budgetAmount', 'remainingBudget', 'currentMonth'
        ));
=======
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::latest()->paginate(10);
        return view('admin.expenses.index', compact('expenses'));
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
    }

    public function create()
    {
<<<<<<< HEAD
        $categories = Expense::distinct()->pluck('category');
        $defaultCategories = [
            'Electricity Bill', 'Water Bill', 'Gas Bill', 'Internet',
            'Staff Salary', 'Maintenance', 'Security', 'Cleaning',
            'Repair Work', 'Office Expense', 'Other'
        ];
        $allCategories = $categories->merge($defaultCategories)->unique()->sort();

        return view('admin.expenses.create', compact('allCategories'));
=======
        return view('admin.expenses.create');
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
<<<<<<< HEAD
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'reference_no' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'bill' => 'nullable|image|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        if ($request->hasFile('bill')) {
            $path = $request->file('bill')->store('expense_bills', 'public');
            $validated['bill_path'] = $path;
        }

        Expense::create($validated);

        return redirect()->route('admin.expenses.index')->with('success', 'Expense recorded successfully.');
=======
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'reference_no' => 'nullable|string|max:255',
        ]);

        Expense::create($validated);

        return redirect()->route('admin.expenses.index')->with('success', 'Expense added successfully.');
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
    }

    public function edit(Expense $expense)
    {
<<<<<<< HEAD
        $categories = Expense::distinct()->pluck('category');
        $defaultCategories = [
            'Electricity Bill', 'Water Bill', 'Gas Bill', 'Internet',
            'Staff Salary', 'Maintenance', 'Security', 'Cleaning',
            'Repair Work', 'Office Expense', 'Other'
        ];
        $allCategories = $categories->merge($defaultCategories)->unique()->sort();

        return view('admin.expenses.edit', compact('expense', 'allCategories'));
=======
        return view('admin.expenses.edit', compact('expense'));
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
    }

    public function update(Request $request, Expense $expense)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
<<<<<<< HEAD
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'reference_no' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'bill' => 'nullable|image|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        if ($request->hasFile('bill')) {
            if ($expense->bill_path) {
                Storage::disk('public')->delete($expense->bill_path);
            }
            $path = $request->file('bill')->store('expense_bills', 'public');
            $validated['bill_path'] = $path;
        }

=======
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'reference_no' => 'nullable|string|max:255',
        ]);

>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
        $expense->update($validated);

        return redirect()->route('admin.expenses.index')->with('success', 'Expense updated successfully.');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();
        return redirect()->route('admin.expenses.index')->with('success', 'Expense deleted successfully.');
    }
<<<<<<< HEAD

    public function updateBudget(Request $request)
    {
        $validated = $request->validate([
            'month' => 'required|string',
            'amount' => 'required|numeric|min:0',
        ]);

        ExpenseBudget::updateOrCreate(
            ['month' => $validated['month']],
            ['amount' => $validated['amount']]
        );

        return back()->with('success', 'Monthly budget updated.');
    }

    public function report(Request $request)
    {
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);

        $expenses = Expense::whereMonth('date', $month)
                           ->whereYear('date', $year)
                           ->get();

        $totalMonthly = $expenses->sum('amount');
        $totalYearly = Expense::whereYear('date', $year)->sum('amount');
        
        $categoryWise = Expense::select('category', \DB::raw('SUM(amount) as total'))
                               ->whereMonth('date', $month)
                               ->whereYear('date', $year)
                               ->groupBy('category')
                               ->get();

        return view('admin.expenses.report', compact('totalMonthly', 'totalYearly', 'categoryWise', 'month', 'year'));
    }
=======
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
}
