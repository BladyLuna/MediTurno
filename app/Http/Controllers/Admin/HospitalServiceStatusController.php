<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HospitalService;
use App\Services\AuditLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HospitalServiceStatusController extends Controller
{
    public function __construct(private readonly AuditLogService $auditLogService)
    {
    }

    public function activate(Request $request, HospitalService $hospitalService): RedirectResponse
    {
        $this->authorize('update', $hospitalService);

        DB::transaction(function () use ($request, $hospitalService): void {
            $oldValues = $this->auditableValues($hospitalService);

            $hospitalService->forceFill(['active' => true])->save();

            $this->auditLogService->record(
                'activated',
                $hospitalService,
                $oldValues,
                $this->auditableValues($hospitalService),
                $request
            );
        });

        return back()->with('success', 'Servicio hospitalario activado correctamente.');
    }

    public function deactivate(Request $request, HospitalService $hospitalService): RedirectResponse
    {
        $this->authorize('update', $hospitalService);

        DB::transaction(function () use ($request, $hospitalService): void {
            $oldValues = $this->auditableValues($hospitalService);

            $hospitalService->forceFill(['active' => false])->save();

            $this->auditLogService->record(
                'deactivated',
                $hospitalService,
                $oldValues,
                $this->auditableValues($hospitalService),
                $request
            );
        });

        return back()->with('success', 'Servicio hospitalario desactivado correctamente.');
    }

    /**
     * @return array<string, mixed>
     */
    private function auditableValues(HospitalService $hospitalService): array
    {
        return $hospitalService->only(['id', 'name', 'description', 'active']);
    }
}
