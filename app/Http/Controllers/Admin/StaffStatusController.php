<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Services\AuditLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaffStatusController extends Controller
{
    public function __construct(private readonly AuditLogService $auditLogService)
    {
    }

    public function activate(Request $request, Staff $staff): RedirectResponse
    {
        $this->authorize('update', $staff);

        DB::transaction(function () use ($request, $staff): void {
            $oldValues = $this->auditableValues($staff);

            $staff->forceFill(['active' => true])->save();

            $this->auditLogService->record(
                'activated',
                $staff,
                $oldValues,
                $this->auditableValues($staff),
                $request
            );
        });

        return back()->with('success', 'Personal activado correctamente.');
    }

    public function deactivate(Request $request, Staff $staff): RedirectResponse
    {
        $this->authorize('update', $staff);

        DB::transaction(function () use ($request, $staff): void {
            $oldValues = $this->auditableValues($staff);

            $staff->forceFill(['active' => false])->save();

            $this->auditLogService->record(
                'deactivated',
                $staff,
                $oldValues,
                $this->auditableValues($staff),
                $request
            );
        });

        return back()->with('success', 'Personal desactivado correctamente.');
    }

    /**
     * @return array<string, mixed>
     */
    private function auditableValues(Staff $staff): array
    {
        return $staff->only([
            'id',
            'user_id',
            'hospital_service_id',
            'ci',
            'full_name',
            'position',
            'phone',
            'email',
            'active',
        ]);
    }
}
