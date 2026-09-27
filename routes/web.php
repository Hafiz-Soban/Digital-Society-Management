<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Resident;
use App\Http\Controllers\Security;
use App\Http\Controllers\Auth\OwnerRegistrationController;

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('register', [OwnerRegistrationController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [OwnerRegistrationController::class, 'verifyOwner']);
    Route::get('register/otp', [OwnerRegistrationController::class, 'showOtpForm'])->name('register.otp');
    Route::post('register/otp', [OwnerRegistrationController::class, 'verifyOtp']);
    Route::post('register/resend-otp', [OwnerRegistrationController::class, 'resendOtp'])->name('register.resend-otp');
});

// Root redirect
Route::get('/', fn() => redirect()->route('login'));

// Authentication
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// ============================================================
// ADMIN PORTAL
// ============================================================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');

    // Residents
    Route::resource('residents', Admin\ResidentController::class);

    // Houses
    Route::resource('houses', Admin\HouseController::class);

    // Visitors
    Route::get('/visitors', [Admin\VisitorController::class, 'index'])->name('visitors.index');
    Route::get('/visitors/{visitor}', [Admin\VisitorController::class, 'show'])->name('visitors.show');
    Route::patch('/visitors/{visitor}/status', [Admin\VisitorController::class, 'updateStatus'])->name('visitors.status');
<<<<<<< HEAD
    Route::delete('/visitors/{visitor}', [Admin\VisitorController::class, 'destroy'])->name('visitors.destroy');
=======
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287

    // Complaints
    Route::get('/complaints', [Admin\ComplaintController::class, 'index'])->name('complaints.index');
    Route::get('/complaints/{complaint}', [Admin\ComplaintController::class, 'show'])->name('complaints.show');
    Route::patch('/complaints/{complaint}/assign', [Admin\ComplaintController::class, 'assign'])->name('complaints.assign');
    Route::patch('/complaints/{complaint}/status', [Admin\ComplaintController::class, 'updateStatus'])->name('complaints.status');
    Route::delete('/complaints/{complaint}', [Admin\ComplaintController::class, 'destroy'])->name('complaints.destroy');

    // Maintenance
    Route::get('/maintenance', [Admin\MaintenanceController::class, 'index'])->name('maintenance.index');
    Route::get('/maintenance/{maintenance}', [Admin\MaintenanceController::class, 'show'])->name('maintenance.show');
    Route::patch('/maintenance/{maintenance}/assign', [Admin\MaintenanceController::class, 'assign'])->name('maintenance.assign');
    Route::patch('/maintenance/{maintenance}/status', [Admin\MaintenanceController::class, 'updateStatus'])->name('maintenance.status');
    Route::get('/maintenance-staff', [Admin\MaintenanceController::class, 'staffIndex'])->name('maintenance.staff');
    Route::post('/maintenance-staff', [Admin\MaintenanceController::class, 'staffStore'])->name('maintenance.staff.store');
    Route::patch('/maintenance-staff/{staff}', [Admin\MaintenanceController::class, 'staffUpdate'])->name('maintenance.staff.update');
    Route::delete('/maintenance-staff/{staff}', [Admin\MaintenanceController::class, 'staffDestroy'])->name('maintenance.staff.destroy');

<<<<<<< HEAD
    // Maintenance Management (New Module)
    Route::prefix('maintenance-management')->name('maintenance-management.')->group(function () {
        Route::get('/dashboard', [Admin\MaintenanceManagementController::class, 'dashboard'])->name('dashboard');
        Route::get('/settings', [Admin\MaintenanceManagementController::class, 'settings'])->name('settings');
        Route::post('/settings', [Admin\MaintenanceManagementController::class, 'updateSettings'])->name('settings.update');
        Route::get('/records', [Admin\MaintenanceManagementController::class, 'records'])->name('records');
        Route::get('/payments', [Admin\MaintenanceManagementController::class, 'payments'])->name('payments');
        Route::get('/payments/create', [Admin\MaintenanceManagementController::class, 'createPayment'])->name('payments.create');
        Route::post('/payments', [Admin\MaintenanceManagementController::class, 'storePayment'])->name('payments.store');
    });

=======
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
    // Notices
    Route::resource('notices', Admin\NoticeController::class);

    // Emergency
    Route::get('/emergency', [Admin\EmergencyController::class, 'index'])->name('emergency.index');
    Route::get('/emergency/create', [Admin\EmergencyController::class, 'create'])->name('emergency.create');
    Route::post('/emergency', [Admin\EmergencyController::class, 'store'])->name('emergency.store');
    Route::patch('/emergency/{alert}/resolve', [Admin\EmergencyController::class, 'resolve'])->name('emergency.resolve');

    // Security Logs
    Route::get('/security', [Admin\SecurityController::class, 'index'])->name('security.index');
<<<<<<< HEAD
    Route::delete('/security/{security}', [Admin\SecurityController::class, 'destroy'])->name('security.destroy');

    // Reports
=======

    // Analytics
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
    Route::get('/reports', [Admin\ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/residents', [Admin\ReportController::class, 'residents'])->name('reports.residents');
    Route::get('/reports/visitors', [Admin\ReportController::class, 'visitors'])->name('reports.visitors');
    Route::get('/reports/complaints', [Admin\ReportController::class, 'complaints'])->name('reports.complaints');
    Route::get('/reports/maintenance', [Admin\ReportController::class, 'maintenance'])->name('reports.maintenance');
<<<<<<< HEAD
    Route::get('/reports/vehicles', [Admin\ReportController::class, 'vehicles'])->name('reports.vehicles');
    Route::get('/reports/staff', [Admin\ReportController::class, 'staff'])->name('reports.staff');
    Route::get('/reports/attendance', [Admin\ReportController::class, 'attendance'])->name('reports.attendance');
    Route::get('/reports/salaries', [Admin\ReportController::class, 'salaries'])->name('reports.salaries');
    Route::get('/reports/advances', [Admin\ReportController::class, 'advances'])->name('reports.advances');
    Route::get('/reports/deleted', [Admin\ReportController::class, 'deletedRecords'])->name('reports.deleted');

    // Vehicle Management
    Route::prefix('vehicles')->name('vehicles.')->group(function () {
        Route::get('/dashboard', [Admin\VehicleDashboardController::class, 'index'])->name('dashboard');
        Route::get('/', [Admin\VehicleController::class, 'index'])->name('index');
        Route::get('/create', [Admin\VehicleController::class, 'create'])->name('create');
        Route::post('/', [Admin\VehicleController::class, 'store'])->name('store');
        Route::get('/{vehicle}/edit', [Admin\VehicleController::class, 'edit'])->name('edit');
        Route::patch('/{vehicle}', [Admin\VehicleController::class, 'update'])->name('update');
        Route::delete('/{vehicle}', [Admin\VehicleController::class, 'destroy'])->name('destroy');
        Route::get('/owner/{houseId}', [Admin\VehicleController::class, 'getHouseOwner'])->name('owner');
        
        // Entry Logs
        Route::get('/logs', [Admin\VehicleLogController::class, 'index'])->name('logs.index');
        Route::post('/logs', [Admin\VehicleLogController::class, 'store'])->name('logs.store');
        Route::get('/logs/{log}/edit', [Security\VehicleLogController::class, 'edit'])->name('logs.edit');
        Route::patch('/logs/{log}', [Security\VehicleLogController::class, 'update'])->name('logs.update');
        Route::patch('/logs/{log}/exit', [Admin\VehicleLogController::class, 'update'])->name('logs.exit');
        Route::get('/verify/{vehicleNumber}', [Admin\VehicleLogController::class, 'verify'])->name('verify');

        // Alerts
        Route::get('/alerts', [Admin\VehicleAlertController::class, 'index'])->name('alerts.index');
        // Route::get('/alerts/{alert}', [Admin\VehicleAlertController::class, 'show'])->name('alerts.show');
        Route::patch('/alerts/{alert}/resolve', [Admin\VehicleAlertController::class, 'resolve'])->name('alerts.resolve');
    });

    // Staff Management
    Route::get('/staff/dashboard', [Admin\StaffController::class, 'dashboard'])->name('staff.dashboard');
    Route::resource('staff', Admin\StaffController::class);
    Route::get('/staff-attendance', [Admin\StaffAttendanceController::class, 'index'])->name('staff.attendance.index');
    Route::get('/staff-attendance/create', [Admin\StaffAttendanceController::class, 'create'])->name('staff.attendance.create');
    Route::post('/staff-attendance', [Admin\StaffAttendanceController::class, 'store'])->name('staff.attendance.store');
    Route::resource('staff-salaries', Admin\StaffSalaryController::class);
    Route::resource('staff-advances', Admin\StaffAdvanceController::class);
    Route::resource('emergency-contacts', Admin\EmergencyContactController::class);

    // Expense Management
    Route::get('/expenses/report', [Admin\ExpenseController::class, 'report'])->name('expenses.report');
    Route::post('/expenses/budget', [Admin\ExpenseController::class, 'updateBudget'])->name('expenses.budget');
    Route::resource('expenses', Admin\ExpenseController::class);

    // Recycle Bin
    Route::get('/recycle-bin', [Admin\RecycleBinController::class, 'index'])->name('recycle-bin.index');
    Route::post('/recycle-bin/restore', [Admin\RecycleBinController::class, 'restore'])->name('recycle-bin.restore');
    Route::delete('/recycle-bin/permanent-delete', [Admin\RecycleBinController::class, 'permanentDelete'])->name('recycle-bin.permanent-delete');
=======

    // Monthly Expenses
    Route::resource('expenses', Admin\ExpenseController::class);

    // Staff
    Route::resource('staff', Admin\StaffController::class);
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287

    // Settings & Users
    Route::get('/settings', [Admin\SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings/registration', [Admin\SettingsController::class, 'updateRegistrationSettings'])->name('settings.registration');
<<<<<<< HEAD
=======
    Route::post('/settings/maintenance-restriction', [Admin\SettingsController::class, 'updateMaintenanceRestriction'])->name('settings.maintenance-restriction');
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
    Route::get('/settings/users/create', [Admin\SettingsController::class, 'createUser'])->name('settings.users.create');
    Route::post('/settings/users', [Admin\SettingsController::class, 'storeUser'])->name('settings.users.store');
    Route::patch('/settings/users/{user}/status', [Admin\SettingsController::class, 'updateUserStatus'])->name('settings.users.status');
    Route::delete('/settings/users/{user}', [Admin\SettingsController::class, 'destroyUser'])->name('settings.users.destroy');
});

// ============================================================
// RESIDENT PORTAL
// ============================================================
Route::prefix('resident')->name('resident.')->middleware(['auth', 'role:resident'])->group(function () {

    Route::get('/dashboard', [Resident\DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [Resident\ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [Resident\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [Resident\ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [Resident\ProfileController::class, 'changePassword'])->name('profile.password');
    Route::get('/settings', [Resident\ProfileController::class, 'settings'])->name('settings');

    // House Info
    Route::get('/my-house', [Resident\HouseController::class, 'index'])->name('house.index');

    // Visitors
    Route::get('/visitors', [Resident\VisitorController::class, 'index'])->name('visitors.index');
    Route::get('/visitors/create', [Resident\VisitorController::class, 'create'])->name('visitors.create');
    Route::post('/visitors', [Resident\VisitorController::class, 'store'])->name('visitors.store');
    Route::get('/visitors/{visitor}', [Resident\VisitorController::class, 'show'])->name('visitors.show');
    Route::get('/visitors/{visitor}/print', [Resident\VisitorController::class, 'printPass'])->name('visitors.print');
    Route::get('/visitors/{visitor}/edit', [Resident\VisitorController::class, 'edit'])->name('visitors.edit');
    Route::patch('/visitors/{visitor}', [Resident\VisitorController::class, 'update'])->name('visitors.update');
    Route::patch('/visitors/{visitor}/cancel', [Resident\VisitorController::class, 'cancel'])->name('visitors.cancel');

    // Complaints
    Route::get('/complaints', [Resident\ComplaintController::class, 'index'])->name('complaints.index');
    Route::get('/complaints/create', [Resident\ComplaintController::class, 'create'])->name('complaints.create');
    Route::post('/complaints', [Resident\ComplaintController::class, 'store'])->name('complaints.store');
    Route::get('/complaints/{complaint}', [Resident\ComplaintController::class, 'show'])->name('complaints.show');
    Route::get('/complaints/{complaint}/edit', [Resident\ComplaintController::class, 'edit'])->name('complaints.edit');
    Route::patch('/complaints/{complaint}', [Resident\ComplaintController::class, 'update'])->name('complaints.update');
    Route::delete('/complaints/{complaint}', [Resident\ComplaintController::class, 'destroy'])->name('complaints.destroy');

    // Maintenance
    Route::get('/maintenance', [Resident\MaintenanceController::class, 'index'])->name('maintenance.index');
    Route::get('/maintenance/create', [Resident\MaintenanceController::class, 'create'])->name('maintenance.create');
    Route::post('/maintenance', [Resident\MaintenanceController::class, 'store'])->name('maintenance.store');
    Route::get('/maintenance/{maintenance}', [Resident\MaintenanceController::class, 'show'])->name('maintenance.show');
    Route::get('/maintenance/{maintenance}/edit', [Resident\MaintenanceController::class, 'edit'])->name('maintenance.edit');
    Route::patch('/maintenance/{maintenance}', [Resident\MaintenanceController::class, 'update'])->name('maintenance.update');
    Route::patch('/maintenance/{maintenance}/cancel', [Resident\MaintenanceController::class, 'cancel'])->name('maintenance.cancel');

    // Notices
    Route::get('/notices', [Resident\NoticeController::class, 'index'])->name('notices.index');
    Route::get('/notices/{notice}', [Resident\NoticeController::class, 'show'])->name('notices.show');

    // Emergency
    Route::get('/emergency', [Resident\EmergencyController::class, 'index'])->name('emergency.index');
    Route::post('/emergency/sos', [Resident\EmergencyController::class, 'sos'])->name('emergency.sos');

    // Directory
    Route::get('/directory', [Resident\DirectoryController::class, 'index'])->name('directory.index');

    // Notifications
    Route::get('/notifications', [Resident\NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifications/read-all', [Resident\NotificationController::class, 'markAllRead'])->name('notifications.read-all');
    Route::patch('/notifications/{notification}/read', [Resident\NotificationController::class, 'markRead'])->name('notifications.read');
    Route::delete('/notifications/{notification}', [Resident\NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::get('/notifications/count', [Resident\NotificationController::class, 'getUnreadCount'])->name('notifications.count');
<<<<<<< HEAD
=======

    // Domestic Staff
    Route::get('/domestic-staff', [Resident\DomesticStaffController::class, 'index'])->name('domestic-staff.index');
    Route::get('/domestic-staff/create', [Resident\DomesticStaffController::class, 'create'])->name('domestic-staff.create');
    Route::post('/domestic-staff', [Resident\DomesticStaffController::class, 'store'])->name('domestic-staff.store');
    Route::get('/domestic-staff/{staff}', [Resident\DomesticStaffController::class, 'show'])->name('domestic-staff.show');
    Route::get('/domestic-staff/{staff}/edit', [Resident\DomesticStaffController::class, 'edit'])->name('domestic-staff.edit');
    Route::patch('/domestic-staff/{staff}', [Resident\DomesticStaffController::class, 'update'])->name('domestic-staff.update');
    Route::delete('/domestic-staff/{staff}', [Resident\DomesticStaffController::class, 'destroy'])->name('domestic-staff.destroy');

    Route::get('/domestic-staff/{staff}/qr/image', [Resident\DomesticStaffQrController::class, 'image'])->name('domestic-staff.qr.image');
    Route::get('/domestic-staff/{staff}/qr/download', [Resident\DomesticStaffQrController::class, 'download'])->name('domestic-staff.qr.download');
    Route::get('/domestic-staff/{staff}/qr/print', [Resident\DomesticStaffQrController::class, 'print'])->name('domestic-staff.qr.print');

    Route::post('/domestic-staff/{staff}/attendance', [Resident\DomesticStaffAttendanceController::class, 'store'])->name('domestic-staff.attendance.store');
    Route::patch('/domestic-staff/{staff}/attendance/{attendance}', [Resident\DomesticStaffAttendanceController::class, 'update'])->name('domestic-staff.attendance.update');
    Route::delete('/domestic-staff/{staff}/attendance/{attendance}', [Resident\DomesticStaffAttendanceController::class, 'destroy'])->name('domestic-staff.attendance.destroy');
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
});

// ============================================================
// SECURITY GUARD PORTAL
// ============================================================
Route::prefix('security')->name('security.')->middleware(['auth', 'role:security_guard'])->group(function () {

    Route::get('/dashboard', [Security\DashboardController::class, 'index'])->name('dashboard');

    // Visitors
    Route::get('/visitors', [Security\VisitorController::class, 'index'])->name('visitors.index');
    Route::get('/visitors/create', [Security\VisitorController::class, 'create'])->name('visitors.create');
    Route::post('/visitors', [Security\VisitorController::class, 'store'])->name('visitors.store');
    Route::get('/visitors/{visitor}', [Security\VisitorController::class, 'show'])->name('visitors.show');
    Route::patch('/visitors/{visitor}/checkout', [Security\VisitorController::class, 'checkOut'])->name('visitors.checkout');
    Route::patch('/visitors/{visitor}/approve', [Security\VisitorController::class, 'approve'])->name('visitors.approve');
    Route::patch('/visitors/{visitor}/deny', [Security\VisitorController::class, 'deny'])->name('visitors.deny');

    // Security Incidents
    Route::get('/incidents', [Security\IncidentController::class, 'index'])->name('incidents.index');
    Route::get('/incidents/create', [Security\IncidentController::class, 'create'])->name('incidents.create');
    Route::post('/incidents', [Security\IncidentController::class, 'store'])->name('incidents.store');
    Route::get('/incidents/{incident}', [Security\IncidentController::class, 'show'])->name('incidents.show');
    Route::patch('/incidents/{incident}/status', [Security\IncidentController::class, 'updateStatus'])->name('incidents.status');

    // Entry/Exit Logs
    Route::get('/logs', [Security\SecurityLogController::class, 'index'])->name('logs.index');
    Route::get('/logs/create', [Security\SecurityLogController::class, 'create'])->name('logs.create');
    Route::post('/logs', [Security\SecurityLogController::class, 'store'])->name('logs.store');

    // Emergency
    Route::get('/emergency', [Security\EmergencyController::class, 'index'])->name('emergency.index');
    Route::post('/emergency', [Security\EmergencyController::class, 'store'])->name('emergency.store');
    Route::patch('/emergency/{alert}/resolve', [Security\EmergencyController::class, 'resolve'])->name('emergency.resolve');

    // Residents Directory
    Route::get('/residents', [Security\ResidentController::class, 'index'])->name('residents.index');
    Route::get('/residents/{resident}', [Security\ResidentController::class, 'show'])->name('residents.show');

<<<<<<< HEAD
    // Vehicle Logs
    Route::get('/vehicles/logs', [Security\VehicleLogController::class, 'index'])->name('vehicles.logs.index');
    Route::post('/vehicles/logs', [Security\VehicleLogController::class, 'store'])->name('vehicles.logs.store');
    Route::get('/vehicles/logs/{log}/edit', [Security\VehicleLogController::class, 'edit'])->name('vehicles.logs.edit');
    Route::patch('/vehicles/logs/{log}', [Security\VehicleLogController::class, 'update'])->name('vehicles.logs.update');
    Route::patch('/vehicles/logs/{log}/exit', [Security\VehicleLogController::class, 'update'])->name('vehicles.logs.exit');
    Route::get('/vehicles/verify/{vehicleNumber}', [Admin\VehicleLogController::class, 'verify'])->name('vehicles.verify');

=======
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
    // Notices
    Route::get('/notices', [Security\NoticeController::class, 'index'])->name('notices.index');
    Route::get('/notices/{notice}', [Security\NoticeController::class, 'show'])->name('notices.show');

    // Profile
    Route::get('/profile', [Security\ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [Security\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [Security\ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [Security\ProfileController::class, 'changePassword'])->name('profile.password');

    // Notifications
    Route::get('/notifications', [Security\NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifications/read-all', [Security\NotificationController::class, 'markAllRead'])->name('notifications.read-all');
    Route::patch('/notifications/{notification}/read', [Security\NotificationController::class, 'markRead'])->name('notifications.read');
});
