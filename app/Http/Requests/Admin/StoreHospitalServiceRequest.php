<?php

namespace App\Http\Requests\Admin;

use App\Models\HospitalService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreHospitalServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', HospitalService::class) ?? false;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('hospital_services', 'name')->whereNull('deleted_at'),
            ],
            'description' => ['nullable', 'string'],
            'active' => ['nullable', 'boolean'],
        ];
    }
}
