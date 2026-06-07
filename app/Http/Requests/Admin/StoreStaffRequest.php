<?php

namespace App\Http\Requests\Admin;

use App\Models\Staff;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStaffRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', Staff::class) ?? false;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'hospital_service_id' => [
                'required',
                Rule::exists('hospital_services', 'id')->whereNull('deleted_at'),
            ],
            'user_id' => [
                'nullable',
                Rule::exists('users', 'id')
                    ->where('role', User::ROLE_STAFF)
                    ->whereNull('deleted_at'),
                Rule::unique('staff', 'user_id')->whereNull('deleted_at'),
            ],
            'ci' => [
                'required',
                'string',
                'max:50',
                Rule::unique('staff', 'ci')->whereNull('deleted_at'),
            ],
            'full_name' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'active' => ['nullable', 'boolean'],
        ];
    }
}
