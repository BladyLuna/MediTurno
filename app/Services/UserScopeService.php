<?php

namespace App\Services;

use App\Models\HospitalService;
use App\Models\ServiceShiftTemplate;
use App\Models\ShiftAssignment;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Support\Collection;

class UserScopeService
{
    /**
     * @return array<int, int>
     */
    public function managedHospitalServiceIds(User $user): array
    {
        return $user->serviceManagers()
            ->pluck('hospital_service_id')
            ->map(fn ($id) => (int) $id)
            ->values()
            ->all();
    }

    /**
     * @return \Illuminate\Support\Collection<int, \App\Models\HospitalService>
     */
    public function managedHospitalServices(User $user): Collection
    {
        $serviceIds = $this->managedHospitalServiceIds($user);

        if ($serviceIds === []) {
            return collect();
        }

        return HospitalService::query()
            ->whereIn('id', $serviceIds)
            ->where('active', true)
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    /**
     * @return \Illuminate\Support\Collection<int, \App\Models\Staff>
     */
    public function managedStaff(User $user): Collection
    {
        $serviceIds = $this->managedHospitalServiceIds($user);

        if ($serviceIds === []) {
            return collect();
        }

        return Staff::query()
            ->with('hospitalService')
            ->whereIn('hospital_service_id', $serviceIds)
            ->where('active', true)
            ->orderBy('full_name')
            ->get(['id', 'full_name', 'ci', 'hospital_service_id']);
    }

    /**
     * @return \Illuminate\Support\Collection<int, \App\Models\ServiceShiftTemplate>
     */
    public function managedServiceShiftTemplates(User $user): Collection
    {
        $serviceIds = $this->managedHospitalServiceIds($user);

        if ($serviceIds === []) {
            return collect();
        }

        return ServiceShiftTemplate::query()
            ->with(['hospitalService', 'shiftTemplate'])
            ->whereIn('hospital_service_id', $serviceIds)
            ->where('active', true)
            ->orderBy('hospital_service_id')
            ->get();
    }

    public function personalStaff(User $user): ?Staff
    {
        return $user->staffProfile()
            ->with('hospitalService')
            ->first();
    }

    /**
     * @param  array<int, int>  $serviceIds
     */
    public function serviceIdIsAllowed(?int $serviceId, array $serviceIds): bool
    {
        if ($serviceId === null) {
            return true;
        }

        return in_array($serviceId, $serviceIds, true);
    }

    /**
     * @param  array<int, int>  $serviceIds
     */
    public function staffIdIsAllowed(?int $staffId, array $serviceIds): bool
    {
        if ($staffId === null) {
            return true;
        }

        if ($serviceIds === []) {
            return false;
        }

        return Staff::query()
            ->whereKey($staffId)
            ->whereIn('hospital_service_id', $serviceIds)
            ->exists();
    }

    /**
     * @param  array<int, int>  $serviceIds
     */
    public function serviceShiftTemplateIdIsAllowed(?int $serviceShiftTemplateId, array $serviceIds): bool
    {
        if ($serviceShiftTemplateId === null) {
            return true;
        }

        if ($serviceIds === []) {
            return false;
        }

        return ServiceShiftTemplate::query()
            ->whereKey($serviceShiftTemplateId)
            ->whereIn('hospital_service_id', $serviceIds)
            ->exists();
    }

    public function userCanManageAssignment(User $user, ShiftAssignment $shiftAssignment): bool
    {
        return $user->role === User::ROLE_SERVICE_MANAGER
            && $this->serviceIdIsAllowed(
                $shiftAssignment->hospital_service_id,
                $this->managedHospitalServiceIds($user)
            );
    }

    public function userCanOperateAssignment(User $user, ShiftAssignment $shiftAssignment): bool
    {
        return $this->userCanManageAssignment($user, $shiftAssignment)
            && $shiftAssignment->status !== ShiftAssignment::STATUS_CANCELLED
            && ! $shiftAssignment->trashed();
    }
}
