<?php

namespace App\Http\Requests\Admin;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReportFilterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === User::ROLE_ADMIN;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'hospital_service_id' => [
                'nullable',
                Rule::exists('hospital_services', 'id')->whereNull('deleted_at'),
            ],
            'staff_id' => [
                'nullable',
                Rule::exists('staff', 'id')->whereNull('deleted_at'),
            ],
            'group_by' => ['nullable', Rule::in(['service', 'staff'])],
        ];
    }
}
