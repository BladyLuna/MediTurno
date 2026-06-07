<?php

namespace App\Http\Requests\Admin;

use App\Models\ServiceManager;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class StoreServiceManagerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', ServiceManager::class) ?? false;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'user_id' => [
                'required',
                Rule::exists('users', 'id')
                    ->whereIn('role', [User::ROLE_ADMIN, User::ROLE_SERVICE_MANAGER])
                    ->where('active', true)
                    ->whereNull('deleted_at'),
            ],
            'hospital_service_id' => [
                'required',
                Rule::exists('hospital_services', 'id')
                    ->where('active', true)
                    ->whereNull('deleted_at'),
            ],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            if ($validator->errors()->isNotEmpty()) {
                return;
            }

            $exists = ServiceManager::query()
                ->where('user_id', $this->integer('user_id'))
                ->where('hospital_service_id', $this->integer('hospital_service_id'))
                ->exists();

            if ($exists) {
                $validator->errors()->add('user_id', 'El usuario ya administra este servicio.');
            }
        });
    }
}
