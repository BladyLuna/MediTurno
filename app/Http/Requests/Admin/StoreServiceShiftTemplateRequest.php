<?php

namespace App\Http\Requests\Admin;

use App\Models\ServiceShiftTemplate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreServiceShiftTemplateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', ServiceShiftTemplate::class) ?? false;
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
            'shift_template_id' => [
                'required',
                Rule::exists('shift_templates', 'id')->whereNull('deleted_at'),
                Rule::unique('service_shift_templates', 'shift_template_id')
                    ->where(fn ($query) => $query
                        ->where('hospital_service_id', $this->input('hospital_service_id'))
                        ->whereNull('deleted_at')),
            ],
            'custom_code' => ['nullable', 'string', 'max:20'],
            'custom_name' => ['nullable', 'string', 'max:255'],
            'custom_start_time' => ['nullable', 'required_with:custom_end_time', 'date_format:H:i'],
            'custom_end_time' => ['nullable', 'required_with:custom_start_time', 'date_format:H:i'],
            'custom_color' => ['nullable', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'active' => ['nullable', 'boolean'],
        ];
    }
}
