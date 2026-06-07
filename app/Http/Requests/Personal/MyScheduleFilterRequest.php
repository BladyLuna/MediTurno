<?php

namespace App\Http\Requests\Personal;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class MyScheduleFilterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === User::ROLE_STAFF;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'month' => ['nullable', 'date_format:Y-m'],
            'start' => ['nullable', 'date'],
            'end' => ['nullable', 'date', 'after:start'],
        ];
    }
}
