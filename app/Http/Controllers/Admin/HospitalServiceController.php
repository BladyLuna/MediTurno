<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreHospitalServiceRequest;
use App\Http\Requests\Admin\UpdateHospitalServiceRequest;
use App\Models\HospitalService;
use App\Services\AuditLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class HospitalServiceController extends Controller
{
    public function __construct(private readonly AuditLogService $auditLogService)
    {
    }

    public function index(Request $request): View
    {
        $this->authorize('viewAny', HospitalService::class);

        $hospitalServices = HospitalService::query()
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.hospital-services.index', [
            'hospitalServices' => $hospitalServices,
        ]);
    }

    public function create(Request $request): View
    {
        $this->authorize('create', HospitalService::class);

        return view('admin.hospital-services.create');
    }

    public function store(StoreHospitalServiceRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['active'] = $request->boolean('active', true);

        DB::transaction(function () use ($data, $request): void {
            $hospitalService = HospitalService::create($data);

            $this->auditLogService->record(
                'created',
                $hospitalService,
                null,
                $this->auditableValues($hospitalService),
                $request
            );
        });

        return redirect()
            ->route('admin.hospital-services.index')
            ->with('success', 'Servicio hospitalario creado correctamente.');
    }

    public function edit(Request $request, HospitalService $hospitalService): View
    {
        $this->authorize('update', $hospitalService);

        return view('admin.hospital-services.edit', [
            'hospitalService' => $hospitalService,
        ]);
    }

    public function update(UpdateHospitalServiceRequest $request, HospitalService $hospitalService): RedirectResponse
    {
        $data = $request->validated();

        DB::transaction(function () use ($data, $request, $hospitalService): void {
            $oldValues = $this->auditableValues($hospitalService);

            $hospitalService->fill($data);
            $hospitalService->save();

            $this->auditLogService->record(
                'updated',
                $hospitalService,
                $oldValues,
                $this->auditableValues($hospitalService),
                $request
            );
        });

        return redirect()
            ->route('admin.hospital-services.index')
            ->with('success', 'Servicio hospitalario actualizado correctamente.');
    }

    public function destroy(Request $request, HospitalService $hospitalService): RedirectResponse
    {
        $this->authorize('delete', $hospitalService);

        DB::transaction(function () use ($request, $hospitalService): void {
            $oldValues = $this->auditableValues($hospitalService);

            $hospitalService->delete();

            $this->auditLogService->record(
                'deleted',
                $hospitalService,
                $oldValues,
                null,
                $request
            );
        });

        return redirect()
            ->route('admin.hospital-services.index')
            ->with('success', 'Servicio hospitalario eliminado correctamente.');
    }

    /**
     * @return array<string, mixed>
     */
    private function auditableValues(HospitalService $hospitalService): array
    {
        return $hospitalService->only(['id', 'name', 'description', 'active']);
    }
}
