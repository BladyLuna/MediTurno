<?php

namespace App\Http\Requests\Admin;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CalendarFilterRequest extends FormRequest
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
            'month' => ['nullable', 'date_format:Y-m'],
            'start' => ['nullable', 'date'],
            'end' => ['nullable', 'date', 'after:start'],
            'hospital_service_id' => [
                'nullable',
                Rule::exists('hospital_services', 'id')->whereNull('deleted_at'),
            ],
            'staff_id' => [
                'nullable',
                Rule::exists('staff', 'id')->whereNull('deleted_at'),
            ],
        ];
    }
}
