<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreShiftTemplateRequest;
use App\Http\Requests\Admin\UpdateShiftTemplateRequest;
use App\Models\ShiftTemplate;
use App\Services\AuditLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ShiftTemplateController extends Controller
{
    public function __construct(private readonly AuditLogService $auditLogService)
    {
    }

    public function index(Request $request): View
    {
        $this->authorize('viewAny', ShiftTemplate::class);

        $shiftTemplates = ShiftTemplate::query()
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.shift-templates.index', [
            'shiftTemplates' => $shiftTemplates,
        ]);
    }

    public function create(Request $request): View
    {
        $this->authorize('create', ShiftTemplate::class);

        return view('admin.shift-templates.create');
    }

    public function store(StoreShiftTemplateRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_working_shift'] = $request->boolean('is_working_shift', true);
        $data['active'] = $request->boolean('active', true);

        DB::transaction(function () use ($data, $request): void {
            $shiftTemplate = ShiftTemplate::create($data);

            $this->auditLogService->record(
                'created',
                $shiftTemplate,
                null,
                $this->auditableValues($shiftTemplate),
                $request
            );
        });

        return redirect()
            ->route('admin.shift-templates.index')
            ->with('success', 'Plantilla de turno creada correctamente.');
    }

    public function edit(Request $request, ShiftTemplate $shiftTemplate): View
    {
        $this->authorize('update', $shiftTemplate);

        return view('admin.shift-templates.edit', [
            'shiftTemplate' => $shiftTemplate,
        ]);
    }

    public function update(UpdateShiftTemplateRequest $request, ShiftTemplate $shiftTemplate): RedirectResponse
    {
        $data = $request->validated();
        $data['is_working_shift'] = $request->boolean('is_working_shift');

        DB::transaction(function () use ($data, $request, $shiftTemplate): void {
            $oldValues = $this->auditableValues($shiftTemplate);

            $shiftTemplate->fill($data);
            $shiftTemplate->save();

            $this->auditLogService->record(
                'updated',
                $shiftTemplate,
                $oldValues,
                $this->auditableValues($shiftTemplate),
                $request
            );
        });

        return redirect()
            ->route('admin.shift-templates.index')
            ->with('success', 'Plantilla de turno actualizada correctamente.');
    }

    public function destroy(Request $request, ShiftTemplate $shiftTemplate): RedirectResponse
    {
        $this->authorize('delete', $shiftTemplate);

        DB::transaction(function () use ($request, $shiftTemplate): void {
            $oldValues = $this->auditableValues($shiftTemplate);

            $shiftTemplate->delete();

            $this->auditLogService->record(
                'deleted',
                $shiftTemplate,
                $oldValues,
                null,
                $request
            );
        });

        return redirect()
            ->route('admin.shift-templates.index')
            ->with('success', 'Plantilla de turno eliminada correctamente.');
    }

    /**
     * @return array<string, mixed>
     */
    private function auditableValues(ShiftTemplate $shiftTemplate): array
    {
        return $shiftTemplate->only([
            'id',
            'code',
            'name',
            'start_time',
            'end_time',
            'color',
            'is_working_shift',
            'active',
        ]);
    }
}
