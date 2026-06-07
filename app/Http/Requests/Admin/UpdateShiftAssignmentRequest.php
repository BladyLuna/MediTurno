<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Admin\Concerns\ValidatesShiftAssignment;
use App\Models\ShiftAssignment;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateShiftAssignmentRequest extends FormRequest
{
    use ValidatesShiftAssignment;

    public function authorize(): bool
    {
        $shiftAssignment = $this->route('shift_assignment');

        return $shiftAssignment instanceof ShiftAssignment
            && ($this->user()?->can('update', $shiftAssignment) ?? false);
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
