<?php

namespace App\Http\Controllers\ServiceManager;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceManager\ServiceAvailabilityRequest;
use App\Models\ServiceShiftTemplate;
use App\Models\Staff;
use App\Services\ServiceAvailabilityService;
use App\Services\UserScopeService;
use Illuminate\View\View;

class ServiceAvailabilityController extends Controller
{
    public function __construct(
        private readonly ServiceAvailabilityService $serviceAvailabilityService,
        private readonly UserScopeService $userScopeService
    ) {
    }

    public function index(ServiceAvailabilityRequest $request): View
    {
        $result = null;
        $selectedStaff = null;
        $selectedTemplate = null;

        if ($request->hasCompleteAvailabilityInput()) {
            $selectedStaff = Staff::query()->with('hospitalService')->find($request->integer('staff_id'));
            $selectedTemplate = ServiceShiftTemplate::query()
                ->with(['hospitalService', 'shiftTemplate'])
                ->find($request->integer('service_shift_template_id'));

            if ($selectedStaff && $selectedTemplate) {
                $result = $this->serviceAvailabilityService->check(
                    $selectedStaff->id,
                    $request->input('assignment_date'),
                    $selectedTemplate
                );
            }
        }

        return view('service-manager.availability.index', [
            'filters' => $request->validated(),
            'staffOptions' => $this->userScopeService->managedStaff($request->user()),
            'hospitalServices' => $this->userScopeService->managedHospitalServices($request->user()),
            'serviceShiftTemplates' => $this->userScopeService->managedServiceShiftTemplates($request->user()),
            'result' => $result,
            'selectedStaff' => $selectedStaff,
            'selectedTemplate' => $selectedTemplate,
        ]);
    }
}
