<?php

namespace App\Http\Requests\Admin;

use App\Models\ShiftTemplate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateShiftTemplateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $shiftTemplate = $this->route('shift_template');

        return $shiftTemplate instanceof ShiftTemplate
            && ($this->user()?->can('update', $shiftTemplate) ?? false);
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        /** @var \App\Models\ShiftTemplate $shiftTemplate */
        $shiftTemplate = $this->route('shift_template');

        return [
            'code' => [
                'required',
                'string',
                'max:20',
                Rule::unique('shift_templates', 'code')
                    ->whereNull('deleted_at')
                    ->ignore($shiftTemplate->id),
            ],
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('shift_templates', 'name')
                    ->whereNull('deleted_at')
                    ->ignore($shiftTemplate->id),
            ],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i'],
            'color' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'is_working_shift' => ['nullable', 'boolean'],
        ];
    }
}
