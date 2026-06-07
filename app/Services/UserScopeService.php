<?php

namespace App\Services;

use App\Models\HospitalService;
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
}
