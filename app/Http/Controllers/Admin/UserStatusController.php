<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AuditLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserStatusController extends Controller
{
    public function __construct(private readonly AuditLogService $auditLogService)
    {
    }

    public function activate(Request $request, User $user): RedirectResponse
    {
        $this->authorize('update', $user);

        DB::transaction(function () use ($request, $user): void {
            $oldValues = $this->auditableValues($user);

            $user->forceFill(['active' => true])->save();

            $this->auditLogService->record(
                'activated',
                $user,
                $oldValues,
                $this->auditableValues($user),
                $request
            );
        });

        return back()->with('success', 'Usuario activado correctamente.');
    }

    public function deactivate(Request $request, User $user): RedirectResponse
    {
        $this->authorize('update', $user);

        if ($request->user()->is($user)) {
            return back()->with('error', 'No puedes desactivar tu propio usuario.');
        }

        if ($this->isLastActiveAdmin($user)) {
            return back()->with('error', 'No se puede desactivar el ultimo administrador activo.');
        }

        DB::transaction(function () use ($request, $user): void {
            $oldValues = $this->auditableValues($user);

            $user->forceFill(['active' => false])->save();

            $this->auditLogService->record(
                'deactivated',
                $user,
                $oldValues,
                $this->auditableValues($user),
                $request
            );
        });

        return back()->with('success', 'Usuario desactivado correctamente.');
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
    private function auditableValues(User $user): array
    {
        return $user->only(['id', 'name', 'email', 'role', 'active']);
    }
}
