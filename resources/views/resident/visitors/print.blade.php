<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visitor Pass - {{ $visitor->visitor_name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #fff; }
        .pass-card {
            width: 400px;
            margin: 50px auto;
            border: 2px solid #000;
            padding: 0;
            border-radius: 15px;
            overflow: hidden;
            font-family: 'Arial', sans-serif;
        }
        .pass-header {
            background: #0f4c81;
            color: #fff;
            text-align: center;
            padding: 15px;
        }
        .pass-body {
            padding: 20px;
        }
        .qr-placeholder {
            width: 100px;
            height: 100px;
            background: #eee;
            margin: 0 auto 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #ddd;
            font-size: 10px;
            text-align: center;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            border-bottom: 1px dashed #eee;
            padding-bottom: 4px;
        }
        .info-label { font-weight: bold; color: #555; font-size: 12px; }
        .info-value { font-weight: bold; color: #000; font-size: 14px; }
        .pass-footer {
            background: #f8f9fa;
            padding: 10px;
            text-align: center;
            font-size: 10px;
            color: #777;
            border-top: 1px solid #eee;
        }
        @media print {
            .btn-print { display: none; }
            body { background: none; }
            .pass-card { margin: 0; border: 1px solid #000; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="text-center mt-4 btn-print">
        <button onclick="window.print()" class="btn btn-primary">Print Pass</button>
        <a href="{{ route('resident.visitors.show', $visitor) }}" class="btn btn-secondary">Back</a>
    </div>

    <div class="pass-card">
        <div class="pass-header">
            <h5 class="mb-0">SOCIETY VISITOR PASS</h5>
            <small>{{ config('app.name') }}</small>
        </div>
        <div class="pass-body">
            <div class="qr-placeholder">
                VISITOR PASS<br>#{{ $visitor->id }}<br>VALID: {{ $visitor->expected_arrival ? $visitor->expected_arrival->format('d/m/Y') : date('d/m/Y') }}
            </div>
            
            <div class="info-row">
                <span class="info-label">Visitor Name</span>
                <span class="info-value">{{ $visitor->visitor_name }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">CNIC / ID</span>
                <span class="info-value">{{ $visitor->visitor_cnic ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Purpose</span>
                <span class="info-value">{{ $visitor->purpose }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Host Resident</span>
                <span class="info-value">{{ $visitor->resident->user->name }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">House Number</span>
                <span class="info-value">{{ $visitor->resident->house->house_number ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Vehicle #</span>
                <span class="info-value">{{ $visitor->vehicle_number ?? 'N/A' }}</span>
            </div>
            <div class="info-row border-0">
                <span class="info-label">Valid Until</span>
                <span class="info-value">{{ $visitor->expected_arrival ? $visitor->expected_arrival->addDay()->format('d M Y') : 'Today Only' }}</span>
            </div>
        </div>
        <div class="pass-footer">
            This pass is valid for one-time entry. Please keep it with you until exit.
            <br>Contact Security at 1122 for emergencies.
        </div>
    </div>
</body>
</html>
