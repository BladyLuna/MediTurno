<?php

namespace App\Http\Controllers\ServiceManager;

use App\Http\Controllers\Controller;
use App\Models\ShiftAssignment;
use App\Models\ShiftChangeRequest;
use App\Models\Staff;
use App\Models\User;
use App\Services\UserScopeService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceDashboardController extends Controller
{
    public function __construct(private readonly UserScopeService $userScopeService)
    {
    }

    public function index(Request $request): View
    {
        abort_unless($request->user()?->role === User::ROLE_SERVICE_MANAGER, 403);

        $serviceIds = $this->userScopeService->managedHospitalServiceIds($request->user());

        $upcomingAssignments = ShiftAssignment::query()
            ->with(['staff', 'hospitalService', 'serviceShiftTemplate.shiftTemplate'])
            ->when($serviceIds === [], fn ($query) => $query->whereRaw('0 = 1'))
            ->when($serviceIds !== [], fn ($query) => $query->whereIn('hospital_service_id', $serviceIds))
            ->whereIn('status', [ShiftAssignment::STATUS_ASSIGNED, ShiftAssignment::STATUS_CHANGED])
            ->where('start_at', '>=', now()->startOfDay())
            ->orderBy('start_at')
            ->limit(5)
            ->get();

        return view('service-manager.dashboard.index', [
            'services' => $this->userScopeService->managedHospitalServices($request->user()),
            'stats' => [
                'services_count' => count($serviceIds),
                'staff_count' => $this->countStaff($serviceIds),
                'pending_requests_count' => $this->countPendingRequests($serviceIds),
                'upcoming_assignments_count' => $this->countUpcomingAssignments($serviceIds),
            ],
            'upcomingAssignments' => $upcomingAssignments,
            'notice' => $serviceIds === [] ? 'No tienes servicios asociados como jefe de servicio.' : null,
        ]);
    }

    /**
     * @param  array<int, int>  $serviceIds
     */
    private function countStaff(array $serviceIds): int
    {
        if ($serviceIds === []) {
            return 0;
        }

        return Staff::query()
            ->whereIn('hospital_service_id', $serviceIds)
            ->where('active', true)
            ->count();
    }

    /**
     * @param  array<int, int>  $serviceIds
     */
    private function countPendingRequests(array $serviceIds): int
    {
        if ($serviceIds === []) {
            return 0;
        }

        return ShiftChangeRequest::query()
            ->where('status', ShiftChangeRequest::STATUS_PENDING)
            ->whereHas('shiftAssignment', fn ($query) => $query->whereIn('hospital_service_id', $serviceIds))
            ->count();
    }

    /**
     * @param  array<int, int>  $serviceIds
     */
    private function countUpcomingAssignments(array $serviceIds): int
    {
        if ($serviceIds === []) {
            return 0;
        }

        return ShiftAssignment::query()
            ->whereIn('hospital_service_id', $serviceIds)
            ->whereIn('status', [ShiftAssignment::STATUS_ASSIGNED, ShiftAssignment::STATUS_CHANGED])
            ->where('start_at', '>=', now()->startOfDay())
            ->count();
    }
}
