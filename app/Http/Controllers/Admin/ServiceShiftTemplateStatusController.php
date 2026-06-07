<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceShiftTemplate;
use App\Services\AuditLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceShiftTemplateStatusController extends Controller
{
    public function __construct(private readonly AuditLogService $auditLogService)
    {
    }

    public function activate(Request $request, ServiceShiftTemplate $serviceShiftTemplate): RedirectResponse
    {
        $this->authorize('update', $serviceShiftTemplate);

        DB::transaction(function () use ($request, $serviceShiftTemplate): void {
            $oldValues = $this->auditableValues($serviceShiftTemplate);

            $serviceShiftTemplate->forceFill(['active' => true])->save();

            $this->auditLogService->record('activated', $serviceShiftTemplate, $oldValues, $this->auditableValues($serviceShiftTemplate), $request);
        });

        return back()->with('success', 'Turno por servicio activado correctamente.');
    }

    public function deactivate(Request $request, ServiceShiftTemplate $serviceShiftTemplate): RedirectResponse
    {
        $this->authorize('update', $serviceShiftTemplate);

        DB::transaction(function () use ($request, $serviceShiftTemplate): void {
            $oldValues = $this->auditableValues($serviceShiftTemplate);

            $serviceShiftTemplate->forceFill(['active' => false])->save();

            $this->auditLogService->record('deactivated', $serviceShiftTemplate, $oldValues, $this->auditableValues($serviceShiftTemplate), $request);
        });

        return back()->with('success', 'Turno por servicio desactivado correctamente.');
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
