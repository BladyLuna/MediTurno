<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
use App\Services\AuditLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class UserController extends Controller
{
    public function __construct(private readonly AuditLogService $auditLogService)
    {
    }

    public function index(Request $request): View
    {
        $this->authorize('viewAny', User::class);

        $users = User::query()
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.users.index', [
            'users' => $users,
        ]);
    }

    public function create(Request $request): View
    {
        $this->authorize('create', User::class);

        return view('admin.users.create', [
            'roles' => User::ROLES,
        ]);
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['active'] = $request->boolean('active', true);

        DB::transaction(function () use ($data, $request): void {
            $user = User::create($data);

            $this->auditLogService->record(
                'created',
                $user,
                null,
                $this->auditableValues($user),
                $request
            );
        });

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    public function edit(Request $request, User $user): View
    {
        $this->authorize('update', $user);

        return view('admin.users.edit', [
            'user' => $user,
            'roles' => User::ROLES,
        ]);
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $data = $request->validated();

        if (blank($data['password'] ?? null)) {
            unset($data['password']);
        }

        DB::transaction(function () use ($data, $request, $user): void {
            $oldValues = $this->auditableValues($user);

            $user->fill($data);
            $user->save();

            $this->auditLogService->record(
                'updated',
                $user,
                $oldValues,
                $this->auditableValues($user, array_key_exists('password', $data)),
                $request
            );
        });

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        $this->authorize('delete', $user);

        if ($request->user()->is($user)) {
            return back()->with('error', 'No puedes eliminar tu propio usuario.');
        }

        if ($this->isLastActiveAdmin($user)) {
            return back()->with('error', 'No se puede eliminar el ultimo administrador activo.');
        }

        DB::transaction(function () use ($request, $user): void {
            $oldValues = $this->auditableValues($user);

            $user->delete();

            $this->auditLogService->record(
                'deleted',
                $user,
                $oldValues,
                null,
                $request
            );
        });

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }

    private function isLastActiveAdmin(User $user): bool
    {
        return $user->isAdmin()
            && $user->active
            && User::query()
                ->where('role', User::ROLE_ADMIN)
                ->where('active', true)
                ->whereKeyNot($user->id)
                ->doesntExist();
    }

    /**
     * @return array<string, mixed>
     */
    private function auditableValues(User $user, bool $passwordChanged = false): array
    {
        $values = $user->only(['id', 'name', 'email', 'role', 'active']);

        if ($passwordChanged) {
            $values['password_changed'] = true;
        }

        return $values;
    }
}
