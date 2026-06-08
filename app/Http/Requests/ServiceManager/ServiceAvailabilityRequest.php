<?php

namespace App\Http\Requests\ServiceManager;

use App\Models\ServiceShiftTemplate;
use App\Models\Staff;
use App\Models\User;
use App\Services\UserScopeService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class ServiceAvailabilityRequest extends FormRequest
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
            'staff_id' => ['nullable', Rule::exists('staff', 'id')->whereNull('deleted_at')],
            'hospital_service_id' => ['nullable', Rule::exists('hospital_services', 'id')->whereNull('deleted_at')],
            'service_shift_template_id' => ['nullable', Rule::exists('service_shift_templates', 'id')->whereNull('deleted_at')],
            'assignment_date' => ['nullable', 'date'],
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

            if (! $scope->serviceShiftTemplateIdIsAllowed($this->integerOrNull('service_shift_template_id'), $serviceIds)) {
                $validator->errors()->add('service_shift_template_id', 'No puede consultar turnos de otros servicios.');
            }

            $hospitalServiceId = $this->integerOrNull('hospital_service_id');
            $staff = $this->filled('staff_id')
                ? Staff::query()->find($this->integer('staff_id'))
                : null;
            $serviceShiftTemplate = $this->filled('service_shift_template_id')
                ? ServiceShiftTemplate::query()->find($this->integer('service_shift_template_id'))
                : null;

            if ($hospitalServiceId && $staff && $staff->hospital_service_id !== $hospitalServiceId) {
                $validator->errors()->add('staff_id', 'El personal no pertenece al servicio seleccionado.');
            }

            if ($hospitalServiceId && $serviceShiftTemplate && $serviceShiftTemplate->hospital_service_id !== $hospitalServiceId) {
                $validator->errors()->add('service_shift_template_id', 'El turno configurado no pertenece al servicio seleccionado.');
            }
        });
    }

    public function hasCompleteAvailabilityInput(): bool
    {
        return $this->filled('staff_id')
            && $this->filled('hospital_service_id')
            && $this->filled('service_shift_template_id')
            && $this->filled('assignment_date');
    }

    private function integerOrNull(string $key): ?int
    {
        return $this->filled($key) ? $this->integer($key) : null;
    }
}
