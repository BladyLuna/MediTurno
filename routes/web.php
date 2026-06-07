<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuditLogController;
use App\Http\Controllers\Admin\HospitalServiceController;
use App\Http\Controllers\Admin\HospitalServiceStatusController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ServiceShiftTemplateController;
use App\Http\Controllers\Admin\ServiceShiftTemplateStatusController;
use App\Http\Controllers\Admin\ServiceManagerController;
use App\Http\Controllers\Admin\ShiftAssignmentController;
use App\Http\Controllers\Admin\ShiftCalendarController;
use App\Http\Controllers\Admin\ShiftChangeRequestReviewController;
use App\Http\Controllers\Admin\ShiftTemplateController;
use App\Http\Controllers\Admin\ShiftTemplateStatusController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\StaffStatusController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserStatusController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Personal\MyScheduleController;
use App\Http\Controllers\ServiceManager\ServiceCalendarController;
use App\Http\Controllers\ServiceManager\ServiceReportController;
use App\Http\Controllers\ServiceManager\ServiceStaffController;
use App\Http\Controllers\ShiftChangeRequestController;

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

    Route::middleware('role:personal')->group(function () {
        Route::resource('shift-change-requests', ShiftChangeRequestController::class)->only(['index', 'create', 'store', 'show']);
        Route::patch('shift-change-requests/{shift_change_request}/cancel', [ShiftChangeRequestController::class, 'cancel'])->name('shift-change-requests.cancel');
    });

    Route::middleware('role:admin,jefe_servicio')->prefix('admin')->name('admin.')->group(function () {
        Route::get('shift-change-requests', [ShiftChangeRequestReviewController::class, 'index'])->name('shift-change-requests.index');
        Route::get('shift-change-requests/{shift_change_request}', [ShiftChangeRequestReviewController::class, 'show'])->name('shift-change-requests.show');
        Route::patch('shift-change-requests/{shift_change_request}/approve', [ShiftChangeRequestReviewController::class, 'approve'])->name('shift-change-requests.approve');
        Route::patch('shift-change-requests/{shift_change_request}/reject', [ShiftChangeRequestReviewController::class, 'reject'])->name('shift-change-requests.reject');
    });

    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
    Route::patch('notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');

    Route::middleware('role:personal')->group(function () {
        Route::get('my-schedule', [MyScheduleController::class, 'index'])->name('my-schedule.index');
        Route::get('my-schedule/events', [MyScheduleController::class, 'events'])->name('my-schedule.events');
    });

    Route::middleware('role:jefe_servicio')->group(function () {
        Route::get('service-calendar', [ServiceCalendarController::class, 'index'])->name('service-calendar.index');
        Route::get('service-calendar/events', [ServiceCalendarController::class, 'events'])->name('service-calendar.events');
        Route::get('service-staff', [ServiceStaffController::class, 'index'])->name('service-staff.index');
        Route::get('service-reports', [ServiceReportController::class, 'index'])->name('service-reports.index');
        Route::get('service-reports/export', [ServiceReportController::class, 'export'])->name('service-reports.export');
        Route::get('service-reports/pdf', [ServiceReportController::class, 'pdf'])->name('service-reports.pdf');
    });

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
        Route::resource('service-managers', ServiceManagerController::class)->only(['index', 'create', 'store', 'destroy']);
        Route::resource('audit-logs', AuditLogController::class)->only(['index', 'show']);
    });
});
