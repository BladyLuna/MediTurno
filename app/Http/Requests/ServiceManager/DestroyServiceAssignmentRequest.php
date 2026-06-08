<?php

namespace App\Http\Requests\ServiceManager;

use App\Models\ShiftAssignment;
use App\Models\User;
use App\Services\UserScopeService;
use Illuminate\Foundation\Http\FormRequest;

class DestroyServiceAssignmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        $shiftAssignment = $this->route('shift_assignment');

        return $this->user()?->role === User::ROLE_SERVICE_MANAGER
            && $shiftAssignment instanceof ShiftAssignment
            && app(UserScopeService::class)->userCanOperateAssignment($this->user(), $shiftAssignment);
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [];
    }
}
