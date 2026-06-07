<?php

namespace App\Http\Requests\Admin;

use App\Models\ServiceShiftTemplate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateServiceShiftTemplateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $serviceShiftTemplate = $this->route('service_shift_template');

        return $serviceShiftTemplate instanceof ServiceShiftTemplate
            && ($this->user()?->can('update', $serviceShiftTemplate) ?? false);
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        /** @var \App\Models\ServiceShiftTemplate $serviceShiftTemplate */
        $serviceShiftTemplate = $this->route('service_shift_template');

        return [
            'hospital_service_id' => [
                'required',
                Rule::exists('hospital_services', 'id')->whereNull('deleted_at'),
            ],
            'shift_template_id' => [
                'required',
                Rule::exists('shift_templates', 'id')->whereNull('deleted_at'),
                Rule::unique('service_shift_templates', 'shift_template_id')
                    ->where(fn ($query) => $query
                        ->where('hospital_service_id', $this->input('hospital_service_id'))
                        ->whereNull('deleted_at'))
                    ->ignore($serviceShiftTemplate->id),
            ],
            'custom_code' => ['nullable', 'string', 'max:20'],
            'custom_name' => ['nullable', 'string', 'max:255'],
            'custom_start_time' => ['nullable', 'required_with:custom_end_time', 'date_format:H:i'],
            'custom_end_time' => ['nullable', 'required_with:custom_start_time', 'date_format:H:i'],
            'custom_color' => ['nullable', 'regex:/^#[0-9A-Fa-f]{6}$/'],
        ];
    }
}
