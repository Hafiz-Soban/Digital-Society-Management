@extends('layouts.admin')

<<<<<<< HEAD
@section('title', 'Expense Management')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 mb-0">Expense Management</h2>
        <div>
            <button type="button" class="btn btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#budgetModal">
                <i class="bi bi-piggy-bank me-2"></i>Set Budget
            </button>
            <a href="{{ route('admin.expenses.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Add Expense
            </a>
        </div>
    </div>

    <!-- Dashboard Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="bg-primary bg-opacity-10 text-primary rounded p-2">
                            <i class="bi bi-calendar-month fs-4"></i>
                        </div>
                        <span class="text-muted small">This Month</span>
                    </div>
                    <h3 class="h4 fw-bold mb-1">Rs. {{ number_format($totalExpensesMonth, 2) }}</h3>
                    <p class="mb-0 text-muted small">Total Expenses</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="bg-success bg-opacity-10 text-success rounded p-2">
                            <i class="bi bi-calendar-check fs-4"></i>
                        </div>
                        <span class="text-muted small">This Year</span>
                    </div>
                    <h3 class="h4 fw-bold mb-1">Rs. {{ number_format($totalExpensesYear, 2) }}</h3>
                    <p class="mb-0 text-muted small">Total Yearly</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="bg-info bg-opacity-10 text-info rounded p-2">
                            <i class="bi bi-tags fs-4"></i>
                        </div>
                        <span class="text-muted small">Highest Category</span>
                    </div>
                    <h3 class="h4 fw-bold mb-1">{{ $highestCategory ? $highestCategory->category : 'N/A' }}</h3>
                    <p class="mb-0 text-muted small">Rs. {{ $highestCategory ? number_format($highestCategory->total, 2) : '0.00' }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 {{ $remainingBudget < 0 ? 'bg-danger-subtle border-danger' : 'bg-warning-subtle' }}">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="bg-dark bg-opacity-10 text-dark rounded p-2">
                            <i class="bi bi-wallet2 fs-4"></i>
                        </div>
                        <span class="text-muted small">Budget: {{ $currentMonth }}</span>
                    </div>
                    <h3 class="h4 fw-bold mb-1 {{ $remainingBudget < 0 ? 'text-danger' : '' }}">
                        Rs. {{ number_format($remainingBudget, 2) }}
                    </h3>
                    <p class="mb-0 text-muted small">
                        @if($remainingBudget < 0)
                            <span class="text-danger fw-bold"><i class="bi bi-exclamation-triangle-fill me-1"></i>Budget Limit Exceeded</span>
                        @else
                            Remaining from Rs. {{ number_format($budgetAmount, 2) }}
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.expenses.index') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="Search title or ref..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="category" class="form-select">
                        <option value="">All Categories</option>
                        @foreach($allCategories as $cat)
                            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" name="from" class="form-control" value="{{ request('from') }}" title="From Date">
                </div>
                <div class="col-md-2">
                    <input type="date" name="to" class="form-control" value="{{ request('to') }}" title="To Date">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-dark w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Expense List -->
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th>Date</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Amount</th>
                        <th>Ref No.</th>
                        <th class="text-end">Actions</th>
=======
@section('title', 'Monthly Expenses')
@section('page-title', 'Monthly Expenses')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold">Expense List</h5>
        <a href="{{ route('admin.expenses.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Add Expense
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Title</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Category</th>
                        <th>Ref No.</th>
                        <th class="text-end pe-4">Actions</th>
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
                    </tr>
                </thead>
                <tbody>
                    @forelse($expenses as $expense)
<<<<<<< HEAD
                    <tr>
                        <td>{{ $expense->date->format('d M, Y') }}</td>
                        <td>
                            <div class="fw-bold">{{ $expense->title }}</div>
                            <small class="text-muted">{{ Str::limit($expense->description, 30) }}</small>
                        </td>
                        <td><span class="badge bg-secondary-subtle text-secondary">{{ $expense->category }}</span></td>
                        <td class="fw-bold">Rs. {{ number_format($expense->amount, 2) }}</td>
                        <td>{{ $expense->reference_no ?? '-' }}</td>
                        <td class="text-end">
                            <div class="btn-group">
                                @if($expense->bill_path)
                                <a href="{{ asset('storage/' . $expense->bill_path) }}" target="_blank" class="btn btn-sm btn-outline-info" title="View Bill">
                                    <i class="bi bi-file-earmark-image"></i>
                                </a>
                                @endif
                                <a href="{{ route('admin.expenses.edit', $expense) }}" class="btn btn-sm btn-outline-dark" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.expenses.destroy', $expense) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">No expense records found.</td>
                    </tr>
=======
                        <tr>
                            <td class="ps-4">
                                <div class="fw-semibold text-main">{{ $expense->title }}</div>
                                <div class="small text-muted text-truncate" style="max-width: 200px;">{{ $expense->description }}</div>
                            </td>
                            <td><span class="fw-bold">Rs. {{ number_format($expense->amount, 2) }}</span></td>
                            <td>{{ $expense->date->format('M d, Y') }}</td>
                            <td>
                                <span class="badge bg-light text-dark border">{{ $expense->category ?? 'General' }}</span>
                            </td>
                            <td><code class="small">{{ $expense->reference_no ?? '-' }}</code></td>
                            <td class="text-end pe-4">
                                <div class="btn-group">
                                    <a href="{{ route('admin.expenses.edit', $expense) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.expenses.destroy', $expense) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this expense?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-receipt fs-1 d-block mb-3 opacity-25"></i>
                                    No expenses found.
                                </div>
                            </td>
                        </tr>
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
                    @endforelse
                </tbody>
            </table>
        </div>
<<<<<<< HEAD
        @if($expenses->hasPages())
        <div class="card-footer bg-white border-0">
            {{ $expenses->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Budget Modal -->
<div class="modal fade" id="budgetModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content border-0 shadow">
            <div class="modal-header">
                <h5 class="modal-title">Set Monthly Budget</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.expenses.budget') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Month</label>
                        <input type="text" name="month" class="form-control bg-light" value="{{ $currentMonth }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Budget Amount (Rs.)</label>
                        <input type="number" name="amount" class="form-control" value="{{ $budgetAmount }}" required min="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Budget</button>
                </div>
            </form>
        </div>
    </div>
=======
    </div>
    @if($expenses->hasPages())
        <div class="card-footer bg-white py-3">
            {{ $expenses->links() }}
        </div>
    @endif
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
</div>
@endsection
