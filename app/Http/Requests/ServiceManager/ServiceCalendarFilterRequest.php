<?php

namespace App\Http\Requests\ServiceManager;

use App\Models\User;
use App\Services\UserScopeService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class ServiceCalendarFilterRequest extends FormRequest
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
            'month' => ['nullable', 'date_format:Y-m'],
            'start' => ['nullable', 'date'],
            'end' => ['nullable', 'date', 'after:start'],
            'hospital_service_id' => [
                'nullable',
                Rule::exists('hospital_services', 'id')->whereNull('deleted_at'),
            ],
            'staff_id' => [
                'nullable',
                Rule::exists('staff', 'id')->whereNull('deleted_at'),
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
            $serviceIds = $scope->managedHospitalServiceIds($this->user());

            if (! $scope->serviceIdIsAllowed($this->integerOrNull('hospital_service_id'), $serviceIds)) {
                $validator->errors()->add('hospital_service_id', 'No puede consultar servicios no asignados.');
            }

            if (! $scope->staffIdIsAllowed($this->integerOrNull('staff_id'), $serviceIds)) {
                $validator->errors()->add('staff_id', 'No puede consultar personal de otros servicios.');
            }
        });
    }

    private function integerOrNull(string $key): ?int
    {
        return $this->filled($key) ? $this->integer($key) : null;
    }
}
