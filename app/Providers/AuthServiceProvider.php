<?php

namespace App\Providers;

use App\Models\HospitalService;
use App\Models\InternalNotification;
use App\Models\ServiceShiftTemplate;
use App\Models\ServiceManager;
use App\Models\ShiftAssignment;
use App\Models\ShiftChangeRequest;
use App\Models\ShiftTemplate;
use App\Models\Staff;
use App\Models\User;
use App\Policies\HospitalServicePolicy;
use App\Policies\InternalNotificationPolicy;
use App\Policies\ServiceShiftTemplatePolicy;
use App\Policies\ServiceManagerPolicy;
use App\Policies\ShiftAssignmentPolicy;
use App\Policies\ShiftChangeRequestPolicy;
use App\Policies\ShiftTemplatePolicy;
use App\Policies\StaffPolicy;
use App\Policies\UserPolicy;
// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        HospitalService::class => HospitalServicePolicy::class,
        InternalNotification::class => InternalNotificationPolicy::class,
        ServiceManager::class => ServiceManagerPolicy::class,
        ServiceShiftTemplate::class => ServiceShiftTemplatePolicy::class,
        ShiftAssignment::class => ShiftAssignmentPolicy::class,
        ShiftChangeRequest::class => ShiftChangeRequestPolicy::class,
        ShiftTemplate::class => ShiftTemplatePolicy::class,
        Staff::class => StaffPolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
