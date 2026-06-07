<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreStaffRequest;
use App\Http\Requests\Admin\UpdateStaffRequest;
use App\Models\HospitalService;
use App\Models\Staff;
use App\Models\User;
use App\Services\AuditLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class StaffController extends Controller
{
    public function __construct(private readonly AuditLogService $auditLogService)
    {
    }

    public function index(Request $request): View
    {
        $this->authorize('viewAny', Staff::class);

        $staff = Staff::query()
            ->with(['hospitalService', 'user'])
            ->when($request->filled('name'), function ($query) use ($request): void {
                $query->where('full_name', 'like', '%' . $request->string('name') . '%');
            })
            ->when($request->filled('ci'), function ($query) use ($request): void {
                $query->where('ci', 'like', '%' . $request->string('ci') . '%');
            })
            ->when($request->filled('hospital_service_id'), function ($query) use ($request): void {
                $query->where('hospital_service_id', $request->integer('hospital_service_id'));
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.staff.index', [
            'staff' => $staff,
            'hospitalServices' => $this->hospitalServiceOptions(),
            'filters' => $request->only(['name', 'ci', 'hospital_service_id']),
        ]);
    }

    public function create(Request $request): View
    {
        $this->authorize('create', Staff::class);

        return view('admin.staff.create', [
            'hospitalServices' => $this->hospitalServiceOptions(),
            'users' => $this->userOptions(),
        ]);
    }

    public function store(StoreStaffRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['active'] = $request->boolean('active', true);
        $data['user_id'] = $data['user_id'] ?? null;

        DB::transaction(function () use ($data, $request): void {
            $staff = Staff::create($data);

            $this->auditLogService->record(
                'created',
                $staff,
                null,
                $this->auditableValues($staff),
                $request
            );
        });

        return redirect()
            ->route('admin.staff.index')
            ->with('success', 'Personal registrado correctamente.');
    }

    public function edit(Request $request, Staff $staff): View
    {
        $this->authorize('update', $staff);

        $staff->loadMissing(['hospitalService', 'user']);

        return view('admin.staff.edit', [
            'staffMember' => $staff,
            'hospitalServices' => $this->hospitalServiceOptions(),
            'users' => $this->userOptions($staff->user_id),
        ]);
    }

    public function update(UpdateStaffRequest $request, Staff $staff): RedirectResponse
    {
        $data = $request->validated();
        $data['user_id'] = $data['user_id'] ?? null;

        DB::transaction(function () use ($data, $request, $staff): void {
            $oldValues = $this->auditableValues($staff);

            $staff->fill($data);
            $staff->save();

            $this->auditLogService->record(
                'updated',
                $staff,
                $oldValues,
                $this->auditableValues($staff),
                $request
            );
        });

        return redirect()
            ->route('admin.staff.index')
            ->with('success', 'Personal actualizado correctamente.');
    }

    public function destroy(Request $request, Staff $staff): RedirectResponse
    {
        $this->authorize('delete', $staff);

        DB::transaction(function () use ($request, $staff): void {
            $oldValues = $this->auditableValues($staff);

            $staff->delete();

            $this->auditLogService->record(
                'deleted',
                $staff,
                $oldValues,
                null,
                $request
            );
        });

        return redirect()
            ->route('admin.staff.index')
            ->with('success', 'Personal eliminado correctamente.');
    }

    private function hospitalServiceOptions()
    {
        return HospitalService::query()
            ->where('active', true)
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    private function userOptions(?int $currentUserId = null)
    {
        return User::query()
            ->where('role', User::ROLE_STAFF)
            ->where('active', true)
            ->where(function ($query) use ($currentUserId): void {
                $query->whereDoesntHave('staffProfile')
                    ->when($currentUserId, fn ($query) => $query->orWhere('id', $currentUserId));
            })
            ->orderBy('name')
            ->get(['id', 'name', 'email']);
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
