<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;

class CheckMaintenanceDue
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        
        // Only apply to residents
        if ($user && $user->role && $user->role->name === 'resident') {
            $resident = $user->resident;
            
            if ($resident) {
                $restrictionEnabled = Setting::get('maintenance_restriction_enabled', '0') === '1';
                
                if ($restrictionEnabled && $resident->due_amount > 10000) {
                    // Allowed routes: emergency, profile, logout, and dashboard (to show the warning)
                    $allowedRoutes = [
                        'resident.emergency.index',
                        'resident.emergency.sos',
                        'resident.profile.show',
                        'resident.profile.edit',
                        'resident.profile.update',
                        'resident.profile.password',
                        'resident.dashboard',
                        'logout',
                    ];

                    if (!in_array($request->route()->getName(), $allowedRoutes)) {
                        return redirect()->route('resident.dashboard')->with('error', 'Access restricted due to outstanding maintenance dues (> Rs. 10,000). Please clear your dues to enable all features.');
                    }
                }
            }
        }

        return $next($request);
    }
}
