<?php

namespace App\Http\Controllers\Resident;

use App\Http\Controllers\Controller;
use App\Models\DomesticStaff;
use Illuminate\Support\Facades\Http;

class DomesticStaffQrController extends Controller
{
    private function staffForResident(int $staffId): DomesticStaff
    {
        $resident = auth()->user()->resident;

        if (!$resident) {
            abort(404);
        }

        return DomesticStaff::where('resident_id', $resident->id)->findOrFail($staffId);
    }

    private function buildQrUrl(DomesticStaff $staff): string
    {
        $payload = json_encode([
            'type' => 'domestic_staff',
            'id' => $staff->id,
            'token' => $staff->qr_token,
        ]);

        return 'https://api.qrserver.com/v1/create-qr-code/?size=320x320&data=' . urlencode($payload);
    }

    public function image(int $staff)
    {
        $staffMember = $this->staffForResident($staff);

        return redirect()->away($this->buildQrUrl($staffMember));
    }

    public function download(int $staff)
    {
        $staffMember = $this->staffForResident($staff);
        $url = $this->buildQrUrl($staffMember);
        $response = Http::timeout(10)->get($url);

        if (!$response->successful()) {
            abort(500, 'Unable to generate QR code.');
        }

        $contentType = $response->header('Content-Type', 'image/png');

        return response()->streamDownload(function () use ($response) {
            echo $response->body();
        }, 'staff-' . $staffMember->id . '-qr.png', [
            'Content-Type' => $contentType,
        ]);
    }

    public function print(int $staff)
    {
        $staffMember = $this->staffForResident($staff);

        return view('resident.domestic-staff.qr-print', [
            'staffMember' => $staffMember,
        ]);
    }
}
