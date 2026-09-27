@extends('layouts.admin')

@section('title', 'Deleted Records Report')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h2 class="h4">Deleted Records Report</h2>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.reports.deleted') }}" method="GET" class="row g-3">
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
                        <th>Type</th>
                        <th>Record Name</th>
                        <th>Deleted By</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $log)
                    <tr>
                        <td>{{ $log->created_at->format('d M, Y h:i A') }}</td>
                        <td>{{ class_basename($log->model_type) }}</td>
                        <td>{{ $log->record_name }}</td>
                        <td>{{ $log->user->name ?? 'Unknown' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
