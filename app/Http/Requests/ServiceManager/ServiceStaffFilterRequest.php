<?php

namespace App\Http\Requests\ServiceManager;

use App\Models\User;
use App\Services\UserScopeService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class ServiceStaffFilterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === User::ROLE_SERVICE_MANAGER;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['nullable', 'string', 'max:255'],
            'ci' => ['nullable', 'string', 'max:50'],
            'hospital_service_id' => [
                'nullable',
                Rule::exists('hospital_services', 'id')->whereNull('deleted_at'),
            ],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            if ($validator->errors()->isNotEmpty()) {
                return;
            }

            $scope = app(UserScopeService::class);

            if (! $scope->serviceIdIsAllowed($this->integerOrNull('hospital_service_id'), $scope->managedHospitalServiceIds($this->user()))) {
                $validator->errors()->add('hospital_service_id', 'No puede consultar servicios no asignados.');
            }
        });
    }

    private function integerOrNull(string $key): ?int
    {
        return $this->filled($key) ? $this->integer($key) : null;
    }
}
