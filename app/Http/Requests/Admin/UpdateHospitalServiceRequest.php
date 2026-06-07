<?php

namespace App\Http\Requests\Admin;

use App\Models\HospitalService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateHospitalServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        $hospitalService = $this->route('hospital_service');

        return $hospitalService instanceof HospitalService
            && ($this->user()?->can('update', $hospitalService) ?? false);
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        /** @var \App\Models\HospitalService $hospitalService */
        $hospitalService = $this->route('hospital_service');

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('hospital_services', 'name')
                    ->whereNull('deleted_at')
                    ->ignore($hospitalService->id),
            ],
            'description' => ['nullable', 'string'],
        ];
    }
}
