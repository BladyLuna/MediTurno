<?php

namespace App\Http\Requests;

use App\Models\ShiftAssignment;
use App\Models\ShiftChangeRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class StoreShiftChangeRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', ShiftChangeRequest::class) ?? false;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'shift_assignment_id' => [
                'required',
                Rule::exists('shift_assignments', 'id')->whereNull('deleted_at'),
            ],
            'reason' => ['required', 'string', 'max:1000'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            if ($validator->errors()->isNotEmpty()) {
                return;
            }

            $assignment = ShiftAssignment::query()
                ->with('staff')
                ->find($this->integer('shift_assignment_id'));

            if (! $assignment) {
                return;
            }

            if ($assignment->status === ShiftAssignment::STATUS_CANCELLED) {
                $validator->errors()->add('shift_assignment_id', 'No se puede solicitar cambio de una asignación cancelada.');
            }

            if ($assignment->staff?->user_id !== $this->user()?->id) {
                $validator->errors()->add('shift_assignment_id', 'Solo puede solicitar cambios de sus propias asignaciones.');
            }
        });
    }
}
