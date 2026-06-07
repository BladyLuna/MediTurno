<?php

namespace App\Http\Requests\Admin;

use App\Models\ShiftTemplate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreShiftTemplateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', ShiftTemplate::class) ?? false;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'code' => [
                'required',
                'string',
                'max:20',
                Rule::unique('shift_templates', 'code')->whereNull('deleted_at'),
            ],
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('shift_templates', 'name')->whereNull('deleted_at'),
            ],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i'],
            'color' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'is_working_shift' => ['nullable', 'boolean'],
            'active' => ['nullable', 'boolean'],
        ];
    }
}
