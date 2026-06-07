<?php

namespace App\Http\Requests;

use App\Models\ShiftChangeRequest;
use Illuminate\Foundation\Http\FormRequest;

class ReviewShiftChangeRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        $shiftChangeRequest = $this->route('shift_change_request');

        return $shiftChangeRequest instanceof ShiftChangeRequest
            && ($this->user()?->can('review', $shiftChangeRequest) ?? false);
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'review_notes' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
