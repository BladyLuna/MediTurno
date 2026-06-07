<?php

namespace App\Http\Requests\Admin;

use App\Models\Staff;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStaffRequest extends FormRequest
{
    public function authorize(): bool
    {
        $staff = $this->route('staff');

        return $staff instanceof Staff
            && ($this->user()?->can('update', $staff) ?? false);
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        /** @var \App\Models\Staff $staff */
        $staff = $this->route('staff');

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
                Rule::unique('staff', 'user_id')
                    ->whereNull('deleted_at')
                    ->ignore($staff->id),
            ],
            'ci' => [
                'required',
                'string',
                'max:50',
                Rule::unique('staff', 'ci')
                    ->whereNull('deleted_at')
                    ->ignore($staff->id),
            ],
            'full_name' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
        ];
    }
}
