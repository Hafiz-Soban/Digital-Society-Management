@extends('layouts.admin')

@section('title', 'Advance Salary Report')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h2 class="h4">Advance Salary Report</h2>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.reports.advances') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">From</label>
                    <input type="date" name="from" class="form-control" value="{{ request('from') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">To</label>
                    <input type="date" name="to" class="form-control" value="{{ request('to') }}">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Staff Name</th>
                        <th>Amount</th>
                        <th>Reason</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($advances as $adv)
                    <tr>
                        <td>{{ $adv->advance_date->format('d M, Y') }}</td>
                        <td>{{ $adv->staff->full_name }}</td>
                        <td>Rs. {{ number_format($adv->amount, 2) }}</td>
                        <td>{{ $adv->reason }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
