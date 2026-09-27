<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use App\Models\Resident;
use Illuminate\Http\Request;

class ResidentController extends Controller
{
    public function index(Request $request)
    {
        $query = Resident::with(['user', 'house']);

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->whereHas('user', function($uq) use ($request) {
                    $uq->where('name', 'like', '%' . $request->search . '%')
                       ->orWhere('phone', 'like', '%' . $request->search . '%');
                })
                ->orWhereHas('house', function($hq) use ($request) {
                    $hq->where('house_number', 'like', '%' . $request->search . '%')
                       ->orWhere('block', 'like', '%' . $request->search . '%');
                })
                ->orWhere('resident_id', 'like', '%' . $request->search . '%')
                ->orWhere('cnic', 'like', '%' . $request->search . '%');
            });
        }

        $residents = $query->latest()->paginate(20)->withQueryString();

        return view('security.residents.index', compact('residents'));
    }

    public function show(Resident $resident)
    {
        $resident->load(['user', 'house', 'visitors' => function($q) {
            $q->latest()->take(10);
        }]);
        return view('security.residents.show', compact('resident'));
    }
}
