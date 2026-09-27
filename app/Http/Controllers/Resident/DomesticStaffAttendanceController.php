<?php

namespace App\Http\Controllers\Resident;

use App\Http\Controllers\Controller;
use App\Models\DomesticStaff;
use App\Models\DomesticStaffAttendance;
use Illuminate\Http\Request;

class DomesticStaffAttendanceController extends Controller
{
    private function staffForResident(int $staffId): DomesticStaff
    {
        $resident = auth()->user()->resident;

        if (!$resident) {
            abort(404);
        }

        return DomesticStaff::where('resident_id', $resident->id)->findOrFail($staffId);
    }

    public function store(Request $request, int $staff)
    {
        $staffMember = $this->staffForResident($staff);

        $validated = $request->validate([
            'attendance_date' => 'required|date',
            'status' => 'required|in:present,absent,leave',
            'check_in_time' => 'nullable|date_format:H:i',
            'check_out_time' => 'nullable|date_format:H:i',
        ]);

        DomesticStaffAttendance::updateOrCreate(
            [
                'domestic_staff_id' => $staffMember->id,
                'attendance_date' => $validated['attendance_date'],
            ],
            [
                'status' => $validated['status'],
                'check_in_time' => $validated['check_in_time'] ?? null,
                'check_out_time' => $validated['check_out_time'] ?? null,
            ]
        );

        return redirect()->route('resident.domestic-staff.show', $staffMember->id)
            ->with('success', 'Attendance saved successfully.');
    }

    public function update(Request $request, int $staff, int $attendance)
    {
        $staffMember = $this->staffForResident($staff);

        $attendanceRow = DomesticStaffAttendance::where('domestic_staff_id', $staffMember->id)
            ->findOrFail($attendance);

        $validated = $request->validate([
            'status' => 'required|in:present,absent,leave',
            'check_in_time' => 'nullable|date_format:H:i',
            'check_out_time' => 'nullable|date_format:H:i',
        ]);

        $attendanceRow->update([
            'status' => $validated['status'],
            'check_in_time' => $validated['check_in_time'] ?? null,
            'check_out_time' => $validated['check_out_time'] ?? null,
        ]);

        return redirect()->route('resident.domestic-staff.show', $staffMember->id)
            ->with('success', 'Attendance updated successfully.');
    }

    public function destroy(int $staff, int $attendance)
    {
        $staffMember = $this->staffForResident($staff);

        $attendanceRow = DomesticStaffAttendance::where('domestic_staff_id', $staffMember->id)
            ->findOrFail($attendance);

        $attendanceRow->delete();

        return redirect()->route('resident.domestic-staff.show', $staffMember->id)
            ->with('success', 'Attendance deleted successfully.');
    }
}

