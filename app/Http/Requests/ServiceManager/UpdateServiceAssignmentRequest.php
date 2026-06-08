<?php

namespace App\Http\Requests\ServiceManager;

use App\Http\Requests\ServiceManager\Concerns\ValidatesServiceAssignment;
use App\Models\ShiftAssignment;
use App\Models\User;
use App\Services\UserScopeService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateServiceAssignmentRequest extends FormRequest
{
    use ValidatesServiceAssignment;

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
        return [
            'staff_id' => ['required', Rule::exists('staff', 'id')->whereNull('deleted_at')],
            'hospital_service_id' => ['required', Rule::exists('hospital_services', 'id')->whereNull('deleted_at')],
            'service_shift_template_id' => ['required', Rule::exists('service_shift_templates', 'id')->whereNull('deleted_at')],
            'assignment_date' => ['required', 'date'],
            'notes' => ['nullable', 'string'],
        ];
    }

    protected function shiftAssignmentIdForConflictValidation(): ?int
    {
        return $this->route('shift_assignment')?->id;
    }
}
