<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff QR — {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; }
        .card-print {
            max-width: 520px;
            margin: 40px auto;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            overflow: hidden;
        }
        .header {
            background: #0f4c81;
            color: #fff;
            padding: 14px 18px;
            text-align: center;
        }
        .body { padding: 18px; }
        .qr-box {
            width: 260px;
            height: 260px;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 14px;
            background: #fff;
        }
        @media print {
            .btn-print { display: none; }
            body { background: none; }
            .card-print { margin: 0; border-radius: 0; border: 1px solid #000; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="text-center mt-4 btn-print">
        <button onclick="window.print()" class="btn btn-primary">Print</button>
        <button onclick="window.close()" class="btn btn-secondary">Close</button>
    </div>

    <div class="card-print">
        <div class="header">
            <div class="fw-bold">DOMESTIC STAFF QR</div>
            <div style="font-size:.85rem;opacity:.9">{{ config('app.name') }}</div>
        </div>
        <div class="body">
            <div class="qr-box">
                <img src="{{ route('resident.domestic-staff.qr.image', $staffMember->id) }}" alt="QR" style="width:240px;height:240px">
            </div>
            <div class="text-center">
                <div class="fw-bold fs-5">{{ $staffMember->name }}</div>
                <div class="text-muted">{{ ucfirst(str_replace('_',' ',$staffMember->staff_type)) }}</div>
                <div class="mt-2 small text-muted">Staff ID: #{{ $staffMember->id }}</div>
            </div>
        </div>
    </div>
</body>
</html>

