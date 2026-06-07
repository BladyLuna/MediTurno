<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreServiceShiftTemplateRequest;
use App\Http\Requests\Admin\UpdateServiceShiftTemplateRequest;
use App\Models\HospitalService;
use App\Models\ServiceShiftTemplate;
use App\Models\ShiftTemplate;
use App\Services\AuditLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ServiceShiftTemplateController extends Controller
{
    public function __construct(private readonly AuditLogService $auditLogService)
    {
    }

    public function index(Request $request): View
    {
        $this->authorize('viewAny', ServiceShiftTemplate::class);

        $serviceShiftTemplates = ServiceShiftTemplate::query()
            ->with(['hospitalService', 'shiftTemplate'])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.service-shift-templates.index', [
            'serviceShiftTemplates' => $serviceShiftTemplates,
        ]);
    }

    public function create(Request $request): View
    {
        $this->authorize('create', ServiceShiftTemplate::class);

        return view('admin.service-shift-templates.create', [
            'hospitalServices' => $this->hospitalServiceOptions(),
            'shiftTemplates' => $this->shiftTemplateOptions(),
        ]);
    }

    public function store(StoreServiceShiftTemplateRequest $request): RedirectResponse
    {
        $data = $this->normalizeOptionalFields($request->validated());
        $data['active'] = $request->boolean('active', true);

        DB::transaction(function () use ($data, $request): void {
            $serviceShiftTemplate = ServiceShiftTemplate::create($data);

            $this->auditLogService->record(
                'created',
                $serviceShiftTemplate,
                null,
                $this->auditableValues($serviceShiftTemplate),
                $request
            );
        });

        return redirect()
            ->route('admin.service-shift-templates.index')
            ->with('success', 'Turno por servicio configurado correctamente.');
    }

    public function edit(Request $request, ServiceShiftTemplate $serviceShiftTemplate): View
    {
        $this->authorize('update', $serviceShiftTemplate);

        return view('admin.service-shift-templates.edit', [
            'serviceShiftTemplate' => $serviceShiftTemplate,
            'hospitalServices' => $this->hospitalServiceOptions(),
            'shiftTemplates' => $this->shiftTemplateOptions(),
        ]);
    }

    public function update(UpdateServiceShiftTemplateRequest $request, ServiceShiftTemplate $serviceShiftTemplate): RedirectResponse
    {
        $data = $this->normalizeOptionalFields($request->validated());

        DB::transaction(function () use ($data, $request, $serviceShiftTemplate): void {
            $oldValues = $this->auditableValues($serviceShiftTemplate);

            $serviceShiftTemplate->fill($data);
            $serviceShiftTemplate->save();

            $this->auditLogService->record(
                'updated',
                $serviceShiftTemplate,
                $oldValues,
                $this->auditableValues($serviceShiftTemplate),
                $request
            );
        });

        return redirect()
            ->route('admin.service-shift-templates.index')
            ->with('success', 'Turno por servicio actualizado correctamente.');
    }

    public function destroy(Request $request, ServiceShiftTemplate $serviceShiftTemplate): RedirectResponse
    {
        $this->authorize('delete', $serviceShiftTemplate);

        DB::transaction(function () use ($request, $serviceShiftTemplate): void {
            $oldValues = $this->auditableValues($serviceShiftTemplate);

            $serviceShiftTemplate->delete();

            $this->auditLogService->record(
                'deleted',
                $serviceShiftTemplate,
                $oldValues,
                null,
                $request
            );
        });

        return redirect()
            ->route('admin.service-shift-templates.index')
            ->with('success', 'Turno por servicio eliminado correctamente.');
    }

    private function hospitalServiceOptions()
    {
        return HospitalService::query()
            ->where('active', true)
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    private function shiftTemplateOptions()
    {
        return ShiftTemplate::query()
            ->where('active', true)
            ->orderBy('name')
            ->get(['id', 'code', 'name']);
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    private function normalizeOptionalFields(array $data): array
    {
        foreach (['custom_code', 'custom_name', 'custom_start_time', 'custom_end_time', 'custom_color'] as $field) {
            if (($data[$field] ?? null) === '') {
                $data[$field] = null;
            }
        }

        return $data;
    }

    /**
     * @return array<string, mixed>
     */
    private function auditableValues(ServiceShiftTemplate $serviceShiftTemplate): array
    {
        return $serviceShiftTemplate->only([
            'id',
            'hospital_service_id',
            'shift_template_id',
            'custom_code',
            'custom_name',
            'custom_start_time',
            'custom_end_time',
            'custom_color',
            'active',
        ]);
    }
}
