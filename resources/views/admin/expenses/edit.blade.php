@extends('layouts.admin')

@section('title', 'Edit Expense')
<<<<<<< HEAD

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ route('admin.expenses.index') }}" class="btn btn-sm btn-outline-secondary mb-3">
            <i class="bi bi-arrow-left me-1"></i>Back to List
        </a>
        <h2 class="h4">Edit Expense Record</h2>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('admin.expenses.update', $expense) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">Expense Title</label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $expense->title) }}" required>
                                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Category</label>
                                <div class="input-group">
                                    <select name="category" id="category_select" class="form-select @error('category') is-invalid @enderror" required>
                                        @foreach($allCategories as $cat)
                                            <option value="{{ $cat }}" {{ old('category', $expense->category) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                        @endforeach
                                    </select>
                                    <button class="btn btn-outline-secondary" type="button" onclick="toggleNewCategory()">
                                        <i class="bi bi-plus-lg"></i>
                                    </button>
                                </div>
                                <div id="new_category_div" class="mt-2" style="display: none;">
                                    <input type="text" id="new_category_input" class="form-control" placeholder="Enter new category">
                                    <div class="mt-1">
                                        <button type="button" class="btn btn-sm btn-primary" onclick="addNewCategory()">Add</button>
                                        <button type="button" class="btn btn-sm btn-link text-danger" onclick="toggleNewCategory()">Cancel</button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Amount (Rs.)</label>
                                <input type="number" name="amount" class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount', $expense->amount) }}" required min="0" step="0.01">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Date</label>
                                <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date', $expense->date->format('Y-m-d')) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Reference Number</label>
                                <input type="text" name="reference_no" class="form-control" value="{{ old('reference_no', $expense->reference_no) }}">
                            </div>

                            <div class="col-12">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="3">{{ old('description', $expense->description) }}</textarea>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Bill / Receipt Image</label>
                                @if($expense->bill_path)
                                    <div class="mb-2">
                                        <a href="{{ asset('storage/' . $expense->bill_path) }}" target="_blank" class="btn btn-sm btn-light">
                                            <i class="bi bi-file-earmark-image me-1"></i>View Current Bill
                                        </a>
                                    </div>
                                @endif
                                <input type="file" name="bill" class="form-control">
                            </div>

                            <div class="col-12 mt-4">
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary btn-lg">Update Expense</button>
                                    <a href="{{ route('admin.expenses.index') }}" class="btn btn-outline-secondary">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
=======
@section('page-title', 'Edit Expense')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">Update Expense Details</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.expenses.update', $expense) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $expense->title) }}" required>
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Amount (Rs.) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">Rs.</span>
                                <input type="number" step="0.01" name="amount" class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount', $expense->amount) }}" required>
                            </div>
                            @error('amount') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Date <span class="text-danger">*</span></label>
                            <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date', $expense->date->format('Y-m-d')) }}" required>
                            @error('date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Category</label>
                            <select name="category" class="form-select @error('category') is-invalid @enderror">
                                <option value="">Select Category</option>
                                <option value="Utility" {{ old('category', $expense->category) == 'Utility' ? 'selected' : '' }}>Utility Bill</option>
                                <option value="Salary" {{ old('category', $expense->category) == 'Salary' ? 'selected' : '' }}>Staff Salary</option>
                                <option value="Maintenance" {{ old('category', $expense->category) == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                                <option value="Supplies" {{ old('category', $expense->category) == 'Supplies' ? 'selected' : '' }}>Supplies</option>
                                <option value="Other" {{ old('category', $expense->category) == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Reference No.</label>
                            <input type="text" name="reference_no" class="form-control @error('reference_no') is-invalid @enderror" value="{{ old('reference_no', $expense->reference_no) }}">
                            @error('reference_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description', $expense->description) }}</textarea>
                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.expenses.index') }}" class="btn btn-light px-4">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4">Update Expense</button>
                    </div>
                </form>
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
            </div>
        </div>
    </div>
</div>
<<<<<<< HEAD

<script>
function toggleNewCategory() {
    const div = document.getElementById('new_category_div');
    if (div.style.display === 'none') {
        div.style.display = 'block';
        document.getElementById('new_category_input').focus();
    } else {
        div.style.display = 'none';
    }
}

function addNewCategory() {
    const input = document.getElementById('new_category_input');
    const select = document.getElementById('category_select');
    const val = input.value.trim();
    if (val) {
        const option = document.createElement('option');
        option.value = val;
        option.text = val;
        select.add(option);
        select.value = val;
        input.value = '';
        toggleNewCategory();
    }
}
</script>
=======
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
@endsection
