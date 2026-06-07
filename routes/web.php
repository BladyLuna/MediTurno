<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuditLogController;
use App\Http\Controllers\Admin\HospitalServiceController;
use App\Http\Controllers\Admin\HospitalServiceStatusController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ServiceShiftTemplateController;
use App\Http\Controllers\Admin\ServiceShiftTemplateStatusController;
use App\Http\Controllers\Admin\ShiftAssignmentController;
use App\Http\Controllers\Admin\ShiftCalendarController;
use App\Http\Controllers\Admin\ShiftTemplateController;
use App\Http\Controllers\Admin\ShiftTemplateStatusController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\StaffStatusController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserStatusController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
});

Route::middleware(['auth', 'active'])->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('role:admin,jefe_servicio,personal')
        ->name('dashboard');

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', UserController::class)->except(['show']);
        Route::patch('users/{user}/activate', [UserStatusController::class, 'activate'])->name('users.activate');
        Route::patch('users/{user}/deactivate', [UserStatusController::class, 'deactivate'])->name('users.deactivate');
        Route::resource('hospital-services', HospitalServiceController::class)->except(['show']);
        Route::patch('hospital-services/{hospital_service}/activate', [HospitalServiceStatusController::class, 'activate'])->name('hospital-services.activate');
        Route::patch('hospital-services/{hospital_service}/deactivate', [HospitalServiceStatusController::class, 'deactivate'])->name('hospital-services.deactivate');
        Route::resource('staff', StaffController::class)->except(['show']);
        Route::patch('staff/{staff}/activate', [StaffStatusController::class, 'activate'])->name('staff.activate');
        Route::patch('staff/{staff}/deactivate', [StaffStatusController::class, 'deactivate'])->name('staff.deactivate');
        Route::resource('shift-templates', ShiftTemplateController::class)->except(['show']);
        Route::patch('shift-templates/{shift_template}/activate', [ShiftTemplateStatusController::class, 'activate'])->name('shift-templates.activate');
        Route::patch('shift-templates/{shift_template}/deactivate', [ShiftTemplateStatusController::class, 'deactivate'])->name('shift-templates.deactivate');
        Route::resource('service-shift-templates', ServiceShiftTemplateController::class)->except(['show']);
        Route::patch('service-shift-templates/{service_shift_template}/activate', [ServiceShiftTemplateStatusController::class, 'activate'])->name('service-shift-templates.activate');
        Route::patch('service-shift-templates/{service_shift_template}/deactivate', [ServiceShiftTemplateStatusController::class, 'deactivate'])->name('service-shift-templates.deactivate');
        Route::resource('shift-assignments', ShiftAssignmentController::class)->except(['show']);
        Route::get('calendar', [ShiftCalendarController::class, 'index'])->name('calendar.index');
        Route::get('calendar/events', [ShiftCalendarController::class, 'events'])->name('calendar.events');
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('reports/export', [ReportController::class, 'export'])->name('reports.export');
        Route::get('reports/pdf', [ReportController::class, 'pdf'])->name('reports.pdf');
        Route::resource('audit-logs', AuditLogController::class)->only(['index', 'show']);
    });
});
