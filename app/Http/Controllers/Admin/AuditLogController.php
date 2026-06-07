<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuditLogController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('viewAny', User::class);

        $auditLogs = AuditLog::query()
            ->with('user')
            ->latest('created_at')
            ->paginate(15)
            ->withQueryString();

        return view('admin.audit-logs.index', [
            'auditLogs' => $auditLogs,
        ]);
    }

    public function show(Request $request, AuditLog $auditLog): View
    {
        $this->authorize('viewAny', User::class);

        return view('admin.audit-logs.show', [
            'auditLog' => $auditLog->load('user'),
        ]);
    }
}
