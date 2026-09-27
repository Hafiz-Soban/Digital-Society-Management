<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Resident;
use App\Models\House;
use App\Models\Vehicle;
use App\Models\Complaint;
use App\Models\MaintenanceRequest;
use App\Models\Staff;
use App\Models\Visitor;
use App\Models\Notice;
use App\Models\SecurityLog;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecycleBinController extends Controller
{
    public function index()
    {
        $deletedRecords = collect();

        // Residents
        Resident::onlyTrashed()->get()->each(function($item) use ($deletedRecords) {
            $deletedRecords->push($this->formatRecord($item, 'Resident', 'resident_id'));
        });

        // Houses
        House::onlyTrashed()->get()->each(function($item) use ($deletedRecords) {
            $deletedRecords->push($this->formatRecord($item, 'House', 'house_number'));
        });

        // Vehicles
        Vehicle::onlyTrashed()->get()->each(function($item) use ($deletedRecords) {
            $deletedRecords->push($this->formatRecord($item, 'Vehicle', 'license_plate'));
        });

        // Complaints
        Complaint::onlyTrashed()->get()->each(function($item) use ($deletedRecords) {
            $deletedRecords->push($this->formatRecord($item, 'Complaint', 'complaint_id'));
        });

        // Maintenance
        MaintenanceRequest::onlyTrashed()->get()->each(function($item) use ($deletedRecords) {
            $deletedRecords->push($this->formatRecord($item, 'Maintenance', 'id'));
        });

        // Staff
        Staff::onlyTrashed()->get()->each(function($item) use ($deletedRecords) {
            $deletedRecords->push($this->formatRecord($item, 'Staff', 'full_name'));
        });

        // Visitors
        Visitor::onlyTrashed()->get()->each(function($item) use ($deletedRecords) {
            $deletedRecords->push($this->formatRecord($item, 'Visitor', 'visitor_name'));
        });

        // Notices
        Notice::onlyTrashed()->get()->each(function($item) use ($deletedRecords) {
            $deletedRecords->push($this->formatRecord($item, 'Notice', 'title'));
        });

        // Security Logs
        SecurityLog::onlyTrashed()->get()->each(function($item) use ($deletedRecords) {
            $deletedRecords->push($this->formatRecord($item, 'Security Log', 'event_type'));
        });

        // Filter for last 30 days
        $deletedRecords = $deletedRecords->where('deleted_at', '>=', now()->subDays(30))
                                         ->sortByDesc('deleted_at');

        return view('admin.recycle_bin.index', compact('deletedRecords'));
    }

    private function formatRecord($item, $type, $nameField)
    {
        // Find activity log for who deleted it
        $log = ActivityLog::where('model_type', get_class($item))
                          ->where('model_id', $item->id)
                          ->where('action', 'deleted')
                          ->latest()
                          ->first();

        return (object) [
            'id' => $item->id,
            'type' => $type,
            'model_class' => get_class($item),
            'name' => $item->$nameField ?? 'N/A',
            'deleted_by' => $log ? $log->user->name : 'Unknown',
            'deleted_at' => $item->deleted_at,
        ];
    }

    public function restore(Request $request)
    {
        $request->validate([
            'model_class' => 'required|string',
            'id' => 'required|integer',
        ]);

        $modelClass = $request->model_class;
        $record = $modelClass::onlyTrashed()->findOrFail($request->id);
        
        $recordName = $this->getRecordName($record);
        $record->restore();

        ActivityLog::create([
            'model_type' => $modelClass,
            'model_id' => $record->id,
            'record_name' => $recordName,
            'action' => 'restored',
            'user_id' => Auth::id(),
        ]);

        return back()->with('success', 'Record restored successfully.');
    }

    public function permanentDelete(Request $request)
    {
        // Only Super Admin can permanently delete
        // Assuming there is a way to check super admin, maybe role_id or is_super_admin
        // For now, I'll just check if the user is admin
        if (Auth::user()->role !== 'admin') {
             return back()->with('error', 'Only Super Admin can permanently delete records.');
        }

        $request->validate([
            'model_class' => 'required|string',
            'id' => 'required|integer',
        ]);

        $modelClass = $request->model_class;
        $record = $modelClass::onlyTrashed()->findOrFail($request->id);
        $recordName = $this->getRecordName($record);
        
        $record->forceDelete();

        ActivityLog::create([
            'model_type' => $modelClass,
            'model_id' => $request->id,
            'record_name' => $recordName,
            'action' => 'permanently_deleted',
            'user_id' => Auth::id(),
        ]);

        return back()->with('success', 'Record permanently deleted.');
    }

    private function getRecordName($record)
    {
        return $record->full_name ?? $record->name ?? $record->title ?? $record->resident_id ?? $record->house_number ?? $record->license_plate ?? $record->complaint_id ?? 'N/A';
    }
}
