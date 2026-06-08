<?php

namespace App\Http\Requests\ServiceManager\Concerns;

use App\Models\HospitalService;
use App\Models\ServiceShiftTemplate;
use App\Models\Staff;
use App\Services\ShiftConflictService;
use App\Services\ShiftTimeService;
use App\Services\UserScopeService;
use Illuminate\Validation\Validator;

trait ValidatesServiceAssignment
{
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            if ($validator->errors()->isNotEmpty()) {
                return;
            }

            $scope = app(UserScopeService::class);
            $serviceIds = $scope->managedHospitalServiceIds($this->user());

            $staff = Staff::query()->find($this->integer('staff_id'));
            $hospitalService = HospitalService::query()->find($this->integer('hospital_service_id'));
            $serviceShiftTemplate = ServiceShiftTemplate::query()
                ->with('shiftTemplate')
                ->find($this->integer('service_shift_template_id'));

            if (! $staff || ! $hospitalService || ! $serviceShiftTemplate) {
                return;
            }

            if (! $scope->serviceIdIsAllowed($hospitalService->id, $serviceIds)) {
                $validator->errors()->add('hospital_service_id', 'No puede operar este servicio.');
            }

            if (! $scope->staffIdIsAllowed($staff->id, $serviceIds)) {
                $validator->errors()->add('staff_id', 'No puede operar personal de otros servicios.');
            }

            if (! $scope->serviceShiftTemplateIdIsAllowed($serviceShiftTemplate->id, $serviceIds)) {
                $validator->errors()->add('service_shift_template_id', 'No puede usar turnos de otros servicios.');
            }

            if (! $staff->active) {
                $validator->errors()->add('staff_id', 'El personal seleccionado no está activo.');
            }

            if (! $hospitalService->active) {
                $validator->errors()->add('hospital_service_id', 'El servicio seleccionado no está activo.');
            }

            if (! $serviceShiftTemplate->active) {
                $validator->errors()->add('service_shift_template_id', 'El turno por servicio seleccionado no está activo.');
            }

            if ($staff->hospital_service_id !== $hospitalService->id) {
                $validator->errors()->add('staff_id', 'El personal no pertenece al servicio seleccionado.');
            }

            if ($serviceShiftTemplate->hospital_service_id !== $hospitalService->id) {
                $validator->errors()->add('service_shift_template_id', 'El turno configurado no pertenece al servicio seleccionado.');
            }

            if ($validator->errors()->isNotEmpty()) {
                return;
            }

            $interval = app(ShiftTimeService::class)->calculateInterval(
                $this->input('assignment_date'),
                $serviceShiftTemplate
            );

            if (app(ShiftConflictService::class)->hasConflict(
                $staff->id,
                $interval['start_at'],
                $interval['end_at'],
                $this->shiftAssignmentIdForConflictValidation()
            )) {
                $validator->errors()->add('service_shift_template_id', 'El turno se traslapa con otra asignación del personal.');
            }
        });
    }

    protected function shiftAssignmentIdForConflictValidation(): ?int
    {
        return null;
    }
}
