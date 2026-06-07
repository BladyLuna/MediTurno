<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreServiceManagerRequest;
use App\Models\HospitalService;
use App\Models\ServiceManager;
use App\Models\User;
use App\Services\AuditLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ServiceManagerController extends Controller
{
    public function __construct(private readonly AuditLogService $auditLogService)
    {
    }

    public function index(Request $request): View
    {
        $this->authorize('viewAny', ServiceManager::class);

        $serviceManagers = ServiceManager::query()
            ->with(['user', 'hospitalService'])
            ->latest()
            ->paginate(10);

        return view('admin.service-managers.index', [
            'serviceManagers' => $serviceManagers,
        ]);
    }

    public function create(Request $request): View
    {
        $this->authorize('create', ServiceManager::class);

        return view('admin.service-managers.create', [
            'users' => $this->managerUserOptions(),
            'hospitalServices' => $this->hospitalServiceOptions(),
        ]);
    }

    public function store(StoreServiceManagerRequest $request): RedirectResponse
    {
        $data = $request->validated();

        DB::transaction(function () use ($data, $request): void {
            $serviceManager = ServiceManager::create($data);

            $this->auditLogService->record('created', $serviceManager, null, $this->auditableValues($serviceManager), $request);
        });

        return redirect()
            ->route('admin.service-managers.index')
            ->with('success', 'Jefe de servicio asociado correctamente.');
    }

    public function destroy(Request $request, ServiceManager $serviceManager): RedirectResponse
    {
        $this->authorize('delete', $serviceManager);

        DB::transaction(function () use ($request, $serviceManager): void {
            $oldValues = $this->auditableValues($serviceManager);

            $serviceManager->delete();

            $this->auditLogService->record('deleted', $serviceManager, $oldValues, null, $request);
        });

        return redirect()
            ->route('admin.service-managers.index')
            ->with('success', 'Asociación eliminada correctamente.');
    }

    private function managerUserOptions()
    {
        return User::query()
            ->whereIn('role', [User::ROLE_ADMIN, User::ROLE_SERVICE_MANAGER])
            ->where('active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'email', 'role']);
    }

    private function hospitalServiceOptions()
    {
        return HospitalService::query()
            ->where('active', true)
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    /**
     * @return array<string, mixed>
     */
    private function auditableValues(ServiceManager $serviceManager): array
    {
        return $serviceManager->only([
            'id',
            'user_id',
            'hospital_service_id',
        ]);
    }
}
