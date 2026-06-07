<?php

namespace App\Http\Controllers\ServiceManager;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceManager\ServiceStaffFilterRequest;
use App\Models\Staff;
use App\Services\UserScopeService;
use Illuminate\View\View;

class ServiceStaffController extends Controller
{
    public function __construct(private readonly UserScopeService $userScopeService)
    {
    }

    public function index(ServiceStaffFilterRequest $request): View
    {
        $filters = $request->validated();
        $serviceIds = $this->userScopeService->managedHospitalServiceIds($request->user());

        $staff = Staff::query()
            ->with(['hospitalService', 'user'])
            ->when($serviceIds === [], fn ($query) => $query->whereRaw('0 = 1'))
            ->when($serviceIds !== [], fn ($query) => $query->whereIn('hospital_service_id', $serviceIds))
            ->when($filters['name'] ?? null, function ($query, string $name): void {
                $query->where('full_name', 'like', '%' . $name . '%');
            })
            ->when($filters['ci'] ?? null, function ($query, string $ci): void {
                $query->where('ci', 'like', '%' . $ci . '%');
            })
            ->when($filters['hospital_service_id'] ?? null, fn ($query, $serviceId) => $query->where('hospital_service_id', $serviceId))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('service-manager.staff.index', [
            'staff' => $staff,
            'hospitalServices' => $this->userScopeService->managedHospitalServices($request->user()),
            'filters' => $filters,
            'notice' => $serviceIds === [] ? 'No tienes servicios asociados como jefe de servicio.' : null,
        ]);
    }
}
