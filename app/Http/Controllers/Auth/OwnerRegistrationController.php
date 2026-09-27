<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\House;
use App\Models\Otp;
use App\Models\Resident;
use App\Models\Role;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class OwnerRegistrationController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function verifyOwner(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'cnic' => 'required|string|max:20',
            'house_number' => 'required|string|exists:houses,house_number',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'confirmed', Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
        ]);

        $house = House::where('house_number', $request->house_number)->first();

        // Strict Rule: One House = One Owner Account
        if (Resident::where('house_id', $house->id)->where('ownership_type', 'owner')->exists()) {
            return back()->withInput()->withErrors(['house_number' => 'An account is already registered for this property.']);
        }

        // Step 1: Owner Verification
        if (
            trim(strtolower($house->owner_name)) !== trim(strtolower($request->name)) ||
            trim($house->owner_cnic) !== trim($request->cnic)
        ) {
            return back()->withInput()->withErrors(['name' => 'Your information does not match the ownership records available in the society database.']);
        }

        // Duplicate CNIC check in Resident table
        if (Resident::where('cnic', $request->cnic)->exists()) {
            return back()->withInput()->withErrors(['cnic' => 'An account with this CNIC is already registered.']);
        }

        // Step 2: Mobile Number Auto Detection
        $mobileNumber = $house->owner_phone;

        // Step 3: OTP Generation
        $otpCode = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        
        Otp::create([
            'identifier' => $mobileNumber,
            'otp' => $otpCode,
            'expires_at' => now()->addMinutes(5),
        ]);

        // SMS Integration Ready - Log for simulation
        Log::info("OTP for owner {$request->name} ({$mobileNumber}): {$otpCode}");
        // In a real system, you would call an SMS gateway here:
        // SMSGateway::send($mobileNumber, "Your verification code is: $otpCode");

        // Store registration data in session temporarily
        Session::put('registration_data', [
            'name' => $request->name,
            'cnic' => $request->cnic,
            'house_id' => $house->id,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $mobileNumber,
        ]);

        return redirect()->route('register.otp')->with('success', 'Your ownership has been verified successfully. OTP has been sent to your registered mobile number.');
    }

    public function showOtpForm()
    {
        if (!Session::has('registration_data')) {
            return redirect()->route('register');
        }

        $phone = Session::get('registration_data')['phone'];
        // Mask the phone number for privacy
        $maskedPhone = substr($phone, 0, 4) . '****' . substr($phone, -3);

        return view('auth.verify-otp', compact('maskedPhone'));
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
        ]);

        if (!Session::has('registration_data')) {
            return redirect()->route('register');
        }

        $regData = Session::get('registration_data');
        $phone = $regData['phone'];

        $otpRecord = Otp::where('identifier', $phone)
            ->where('otp', $request->otp)
            ->whereNull('used_at')
            ->latest()
            ->first();

        if (!$otpRecord || $otpRecord->isExpired()) {
            return back()->withErrors(['otp' => 'The provided OTP is invalid or has expired.']);
        }

        // Step 4: Account Creation
        DB::transaction(function () use ($regData, $otpRecord) {
            $otpRecord->update(['used_at' => now()]);

            $residentRole = Role::where('name', 'resident')->first();
            $status = Setting::get('require_admin_approval', 'no') === 'yes' ? 'pending' : 'active';

            $user = User::create([
                'role_id' => $residentRole->id,
                'name' => $regData['name'],
                'email' => $regData['email'],
                'phone' => $regData['phone'],
                'password' => $regData['password'],
                'status' => $status,
            ]);

            $residentId = 'RES-' . str_pad(Resident::withTrashed()->count() + 1, 3, '0', STR_PAD_LEFT);

            Resident::create([
                'user_id' => $user->id,
                'house_id' => $regData['house_id'],
                'resident_id' => $residentId,
                'cnic' => $regData['cnic'],
                'ownership_type' => 'owner',
                'status' => $status,
                'move_in_date' => now(),
            ]);

            // Update house status
            House::find($regData['house_id'])->update(['status' => 'occupied']);
        });

        Session::forget('registration_data');

        return redirect()->route('login')->with('success', 'Your account has been created successfully. ' . (Setting::get('require_admin_approval') === 'yes' ? 'Please wait for admin approval.' : 'You can now login.'));
    }

    public function resendOtp()
    {
        if (!Session::has('registration_data')) {
            return response()->json(['error' => 'Session expired'], 400);
        }

        $phone = Session::get('registration_data')['phone'];

        // Rate limit: check if last OTP was sent less than 1 minute ago
        $lastOtp = Otp::where('identifier', $phone)->latest()->first();
        if ($lastOtp && $lastOtp->created_at->addMinute()->isFuture()) {
            return back()->withErrors(['otp' => 'Please wait before requesting another OTP.']);
        }

        $otpCode = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        
        Otp::create([
            'identifier' => $phone,
            'otp' => $otpCode,
            'expires_at' => now()->addMinutes(5),
        ]);

        Log::info("Resent OTP for {$phone}: {$otpCode}");

        return back()->with('success', 'A new verification code has been sent to your registered mobile number.');
    }
}
