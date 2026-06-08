<?php

namespace App\Http\Requests\ServiceManager;

use App\Http\Requests\ServiceManager\Concerns\ValidatesServiceAssignment;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreServiceAssignmentRequest extends FormRequest
{
    use ValidatesServiceAssignment;

    public function authorize(): bool
    {
        return $this->user()?->role === User::ROLE_SERVICE_MANAGER;
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
}
