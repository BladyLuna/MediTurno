<?php

namespace Database\Seeders;

use App\Models\AuditLog;
use App\Models\HospitalService;
use App\Models\InternalNotification;
use App\Models\ServiceManager;
use App\Models\ServiceShiftTemplate;
use App\Models\ShiftAssignment;
use App\Models\ShiftChangeRequest;
use App\Models\ShiftTemplate;
use App\Models\Staff;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::query()->where('email', 'admin@mediturno.test')->firstOrFail();
        $manager = User::query()->where('email', 'jefe@mediturno.test')->firstOrFail();
        $personalUser = User::query()->where('email', 'personal@mediturno.test')->firstOrFail();

        $services = $this->seedServices();
        $shiftTemplates = $this->seedShiftTemplates();
        $serviceShiftTemplates = $this->seedServiceShiftTemplates($services, $shiftTemplates);
        $staff = $this->seedStaff($services, $personalUser);
        $this->seedServiceManagers($services, $manager);
        $assignments = $this->seedAssignments($services, $serviceShiftTemplates, $staff, $admin);
        $requests = $this->seedShiftChangeRequests($assignments, $personalUser, $manager);
        $this->seedNotifications($requests, $admin, $manager, $personalUser);
        $this->seedAuditLogs($assignments, $requests, $admin, $manager, $personalUser);
    }

    /**
     * @return array<string, \App\Models\HospitalService>
     */
    private function seedServices(): array
    {
        $data = [
            'emergencia' => ['name' => 'Emergencia', 'description' => 'Atención inmediata de pacientes críticos.'],
            'uci' => ['name' => 'UCI', 'description' => 'Unidad de cuidados intensivos.'],
            'laboratorio' => ['name' => 'Laboratorio', 'description' => 'Servicio de análisis clínico.'],
        ];

        $services = [];

        foreach ($data as $key => $attributes) {
            $services[$key] = HospitalService::query()->updateOrCreate(
                ['name' => $attributes['name']],
                ['description' => $attributes['description'], 'active' => true]
            );
        }

        return $services;
    }

    /**
     * @return array<string, \App\Models\ShiftTemplate>
     */
    private function seedShiftTemplates(): array
    {
        $data = [
            'manana' => ['code' => 'M', 'name' => 'Mañana', 'start_time' => '07:00', 'end_time' => '14:00', 'color' => '#0d6efd', 'is_working_shift' => true],
            'tarde' => ['code' => 'T', 'name' => 'Tarde', 'start_time' => '14:00', 'end_time' => '21:00', 'color' => '#198754', 'is_working_shift' => true],
            'noche' => ['code' => 'N', 'name' => 'Noche', 'start_time' => '21:00', 'end_time' => '07:00', 'color' => '#6610f2', 'is_working_shift' => true],
            'libre' => ['code' => 'L', 'name' => 'Libre', 'start_time' => '00:00', 'end_time' => '00:00', 'color' => '#6c757d', 'is_working_shift' => false],
        ];

        $templates = [];

        foreach ($data as $key => $attributes) {
            $templates[$key] = ShiftTemplate::query()->updateOrCreate(
                ['code' => $attributes['code']],
                [
                    'name' => $attributes['name'],
                    'start_time' => $attributes['start_time'],
                    'end_time' => $attributes['end_time'],
                    'color' => $attributes['color'],
                    'is_working_shift' => $attributes['is_working_shift'],
                    'active' => true,
                ]
            );
        }

        return $templates;
    }

    /**
     * @param  array<string, \App\Models\HospitalService>  $services
     * @param  array<string, \App\Models\ShiftTemplate>  $shiftTemplates
     * @return array<string, array<string, \App\Models\ServiceShiftTemplate>>
     */
    private function seedServiceShiftTemplates(array $services, array $shiftTemplates): array
    {
        $enabled = [
            'emergencia' => ['manana', 'tarde', 'noche'],
            'uci' => ['manana', 'tarde', 'noche'],
            'laboratorio' => ['manana', 'tarde'],
        ];

        $result = [];

        foreach ($enabled as $serviceKey => $shiftKeys) {
            foreach ($shiftKeys as $shiftKey) {
                $result[$serviceKey][$shiftKey] = ServiceShiftTemplate::query()->updateOrCreate(
                    [
                        'hospital_service_id' => $services[$serviceKey]->id,
                        'shift_template_id' => $shiftTemplates[$shiftKey]->id,
                    ],
                    [
                        'custom_code' => null,
                        'custom_name' => null,
                        'custom_start_time' => null,
                        'custom_end_time' => null,
                        'custom_color' => null,
                        'active' => true,
                    ]
                );
            }
        }

        return $result;
    }

    /**
     * @param  array<string, \App\Models\HospitalService>  $services
     * @return array<string, \App\Models\Staff>
     */
    private function seedStaff(array $services, User $personalUser): array
    {
        $staffData = [
            'personal_demo' => ['user_id' => $personalUser->id, 'service' => 'emergencia', 'ci' => '9001001', 'full_name' => 'Personal Demo', 'position' => 'Enfermería', 'phone' => '70000001', 'email' => 'personal.demo@mediturno.test'],
            'ana_rojas' => ['user_id' => null, 'service' => 'emergencia', 'ci' => '9001002', 'full_name' => 'Ana Rojas', 'position' => 'Médica de guardia', 'phone' => '70000002', 'email' => 'ana.rojas@mediturno.test'],
            'luis_mamani' => ['user_id' => null, 'service' => 'uci', 'ci' => '9001003', 'full_name' => 'Luis Mamani', 'position' => 'Licenciado en enfermería', 'phone' => '70000003', 'email' => 'luis.mamani@mediturno.test'],
            'maria_quispe' => ['user_id' => null, 'service' => 'laboratorio', 'ci' => '9001004', 'full_name' => 'María Quispe', 'position' => 'Bioquímica', 'phone' => '70000004', 'email' => 'maria.quispe@mediturno.test'],
        ];

        $staff = [];

        foreach ($staffData as $key => $attributes) {
            $staff[$key] = Staff::query()->updateOrCreate(
                ['ci' => $attributes['ci']],
                [
                    'user_id' => $attributes['user_id'],
                    'hospital_service_id' => $services[$attributes['service']]->id,
                    'full_name' => $attributes['full_name'],
                    'position' => $attributes['position'],
                    'phone' => $attributes['phone'],
                    'email' => $attributes['email'],
                    'active' => true,
                ]
            );
        }

        return $staff;
    }

    /**
     * @param  array<string, \App\Models\HospitalService>  $services
     */
    private function seedServiceManagers(array $services, User $manager): void
    {
        ServiceManager::query()->updateOrCreate(
            ['user_id' => $manager->id, 'hospital_service_id' => $services['emergencia']->id],
            []
        );
    }

    /**
     * @param  array<string, \App\Models\HospitalService>  $services
     * @param  array<string, array<string, \App\Models\ServiceShiftTemplate>>  $serviceShiftTemplates
     * @param  array<string, \App\Models\Staff>  $staff
     * @return array<string, \App\Models\ShiftAssignment>
     */
    private function seedAssignments(array $services, array $serviceShiftTemplates, array $staff, User $admin): array
    {
        $start = CarbonImmutable::now()->startOfMonth()->addDays(6);
        $assignmentData = [
            'personal_morning' => ['staff' => 'personal_demo', 'service' => 'emergencia', 'template' => 'manana', 'start' => $start->setTime(7, 0), 'end' => $start->setTime(14, 0), 'status' => ShiftAssignment::STATUS_ASSIGNED],
            'personal_afternoon' => ['staff' => 'personal_demo', 'service' => 'emergencia', 'template' => 'tarde', 'start' => $start->setTime(14, 0), 'end' => $start->setTime(21, 0), 'status' => ShiftAssignment::STATUS_ASSIGNED],
            'personal_night' => ['staff' => 'personal_demo', 'service' => 'emergencia', 'template' => 'noche', 'start' => $start->addDay()->setTime(21, 0), 'end' => $start->addDays(2)->setTime(7, 0), 'status' => ShiftAssignment::STATUS_CHANGED],
            'ana_afternoon' => ['staff' => 'ana_rojas', 'service' => 'emergencia', 'template' => 'tarde', 'start' => $start->setTime(14, 0), 'end' => $start->setTime(21, 0), 'status' => ShiftAssignment::STATUS_ASSIGNED],
            'luis_night' => ['staff' => 'luis_mamani', 'service' => 'uci', 'template' => 'noche', 'start' => $start->addDays(2)->setTime(21, 0), 'end' => $start->addDays(3)->setTime(7, 0), 'status' => ShiftAssignment::STATUS_ASSIGNED],
            'maria_morning' => ['staff' => 'maria_quispe', 'service' => 'laboratorio', 'template' => 'manana', 'start' => $start->addDays(3)->setTime(7, 0), 'end' => $start->addDays(3)->setTime(14, 0), 'status' => ShiftAssignment::STATUS_ASSIGNED],
        ];

        $assignments = [];

        foreach ($assignmentData as $key => $attributes) {
            $assignments[$key] = ShiftAssignment::query()->updateOrCreate(
                [
                    'staff_id' => $staff[$attributes['staff']]->id,
                    'start_at' => $attributes['start']->format('Y-m-d H:i:s'),
                ],
                [
                    'hospital_service_id' => $services[$attributes['service']]->id,
                    'service_shift_template_id' => $serviceShiftTemplates[$attributes['service']][$attributes['template']]->id,
                    'assignment_date' => $attributes['start']->format('Y-m-d'),
                    'end_at' => $attributes['end']->format('Y-m-d H:i:s'),
                    'status' => $attributes['status'],
                    'notes' => 'Dato demo para defensa.',
                    'created_by' => $admin->id,
                    'updated_by' => $admin->id,
                ]
            );
        }

        return $assignments;
    }

    /**
     * @param  array<string, \App\Models\ShiftAssignment>  $assignments
     * @return array<string, \App\Models\ShiftChangeRequest>
     */
    private function seedShiftChangeRequests(array $assignments, User $personalUser, User $manager): array
    {
        $requests = [];
        $data = [
            'pending' => ['assignment' => 'personal_morning', 'status' => ShiftChangeRequest::STATUS_PENDING, 'reviewed_by' => null, 'review_notes' => null, 'reason' => 'Solicito cambio por compromiso académico.'],
            'approved' => ['assignment' => 'personal_night', 'status' => ShiftChangeRequest::STATUS_APPROVED, 'reviewed_by' => $manager->id, 'review_notes' => 'Aprobado administrativamente para demo.', 'reason' => 'Solicito revisión por guardia nocturna.'],
            'rejected' => ['assignment' => 'personal_afternoon', 'status' => ShiftChangeRequest::STATUS_REJECTED, 'reviewed_by' => $manager->id, 'review_notes' => 'No procede por cobertura del servicio.', 'reason' => 'Solicito cambio de turno de tarde.'],
        ];

        foreach ($data as $key => $attributes) {
            $requests[$key] = ShiftChangeRequest::query()->updateOrCreate(
                ['shift_assignment_id' => $assignments[$attributes['assignment']]->id, 'reason' => $attributes['reason']],
                [
                    'requested_by' => $personalUser->id,
                    'reviewed_by' => $attributes['reviewed_by'],
                    'status' => $attributes['status'],
                    'review_notes' => $attributes['review_notes'],
                ]
            );
        }

        return $requests;
    }

    /**
     * @param  array<string, \App\Models\ShiftChangeRequest>  $requests
     */
    private function seedNotifications(array $requests, User $admin, User $manager, User $personalUser): void
    {
        $notifications = [
            [$manager, 'shift_change_request_created', 'Nueva solicitud de cambio', 'Personal Demo registró una solicitud pendiente.', $requests['pending']],
            [$admin, 'shift_change_request_created', 'Nueva solicitud de cambio', 'Existe una solicitud pendiente para revisión.', $requests['pending']],
            [$personalUser, 'shift_change_request_approved', 'Solicitud aprobada', 'Su solicitud demo fue aprobada administrativamente.', $requests['approved']],
            [$personalUser, 'shift_change_request_rejected', 'Solicitud rechazada', 'Una solicitud demo fue rechazada administrativamente.', $requests['rejected']],
        ];

        foreach ($notifications as [$user, $type, $title, $message, $request]) {
            InternalNotification::query()->updateOrCreate(
                ['user_id' => $user->id, 'type' => $type, 'title' => $title],
                [
                    'message' => $message,
                    'data' => [
                        'shift_change_request_id' => $request->id,
                        'shift_assignment_id' => $request->shift_assignment_id,
                    ],
                    'read_at' => null,
                ]
            );
        }
    }

    /**
     * @param  array<string, \App\Models\ShiftAssignment>  $assignments
     * @param  array<string, \App\Models\ShiftChangeRequest>  $requests
     */
    private function seedAuditLogs(array $assignments, array $requests, User $admin, User $manager, User $personalUser): void
    {
        $logs = [
            [$admin, 'created', ShiftAssignment::class, $assignments['personal_morning']->id, null, ['status' => $assignments['personal_morning']->status]],
            [$personalUser, 'created', ShiftChangeRequest::class, $requests['pending']->id, null, ['status' => ShiftChangeRequest::STATUS_PENDING]],
            [$manager, 'approved', ShiftChangeRequest::class, $requests['approved']->id, ['status' => ShiftChangeRequest::STATUS_PENDING], ['status' => ShiftChangeRequest::STATUS_APPROVED]],
            [$manager, 'rejected', ShiftChangeRequest::class, $requests['rejected']->id, ['status' => ShiftChangeRequest::STATUS_PENDING], ['status' => ShiftChangeRequest::STATUS_REJECTED]],
        ];

        foreach ($logs as [$user, $action, $modelType, $modelId, $oldValues, $newValues]) {
            AuditLog::query()->updateOrCreate(
                ['action' => $action, 'model_type' => $modelType, 'model_id' => $modelId],
                [
                    'user_id' => $user->id,
                    'old_values' => $oldValues,
                    'new_values' => $newValues,
                    'ip_address' => '127.0.0.1',
                    'user_agent' => 'DemoDataSeeder',
                ]
            );
        }
    }
}
