<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShiftTemplate;
use App\Services\AuditLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShiftTemplateStatusController extends Controller
{
    public function __construct(private readonly AuditLogService $auditLogService)
    {
    }

    public function activate(Request $request, ShiftTemplate $shiftTemplate): RedirectResponse
    {
        $this->authorize('update', $shiftTemplate);

        DB::transaction(function () use ($request, $shiftTemplate): void {
            $oldValues = $this->auditableValues($shiftTemplate);

            $shiftTemplate->forceFill(['active' => true])->save();

            $this->auditLogService->record('activated', $shiftTemplate, $oldValues, $this->auditableValues($shiftTemplate), $request);
        });

        return back()->with('success', 'Plantilla de turno activada correctamente.');
    }

    public function deactivate(Request $request, ShiftTemplate $shiftTemplate): RedirectResponse
    {
        $this->authorize('update', $shiftTemplate);

        DB::transaction(function () use ($request, $shiftTemplate): void {
            $oldValues = $this->auditableValues($shiftTemplate);

            $shiftTemplate->forceFill(['active' => false])->save();

            $this->auditLogService->record('deactivated', $shiftTemplate, $oldValues, $this->auditableValues($shiftTemplate), $request);
        });

        return back()->with('success', 'Plantilla de turno desactivada correctamente.');
    }

    /**
     * @return array<string, mixed>
     */
    private function auditableValues(ShiftTemplate $shiftTemplate): array
    {
        return $shiftTemplate->only(['id', 'code', 'name', 'start_time', 'end_time', 'color', 'is_working_shift', 'active']);
    }
}
