<?php

namespace App\Http\Controllers\ServiceManager;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceManager\ServiceReportFilterRequest;
use App\Services\ReportService;
use App\Services\UserScopeService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\View\View;

class ServiceReportController extends Controller
{
    public function __construct(
        private readonly ReportService $reportService,
        private readonly UserScopeService $userScopeService
    ) {
    }

    public function index(ServiceReportFilterRequest $request): View
    {
        $serviceIds = $this->userScopeService->managedHospitalServiceIds($request->user());
        $report = $this->reportService->build($request->validated(), [
            'hospital_service_ids' => $serviceIds,
        ]);

        return view('admin.reports.index', [
            'report' => $report,
            'hospitalServices' => $this->userScopeService->managedHospitalServices($request->user()),
            'staffOptions' => $this->userScopeService->managedStaff($request->user()),
            'pageTitle' => 'Reportes por servicio',
            'pageSubtitle' => 'Resumen de turnos asignados en los servicios que administras.',
            'indexRoute' => 'service-reports.index',
            'exportRoute' => 'service-reports.export',
            'pdfRoute' => 'service-reports.pdf',
            'notice' => $serviceIds === [] ? 'No tienes servicios asociados como jefe de servicio.' : null,
        ]);
    }

    public function export(ServiceReportFilterRequest $request): StreamedResponse
    {
        $report = $this->reportService->build($request->validated(), [
            'hospital_service_ids' => $this->userScopeService->managedHospitalServiceIds($request->user()),
        ]);

        $details = $report['details'];
        $filename = 'mediturno-reporte-servicios-' . $report['filters']['start_date'] . '-' . $report['filters']['end_date'] . '.csv';

        return response()->streamDownload(function () use ($details): void {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'Fecha',
                'Personal',
                'CI',
                'Servicio',
                'Turno',
                'Estado',
                'Inicio',
                'Fin',
                'Horas',
            ]);

            $details->each(function (array $row) use ($handle): void {
                fputcsv($handle, [
                    $row['assignment_date'],
                    $row['staff_name'],
                    $row['staff_ci'],
                    $row['hospital_service_name'],
                    trim($row['shift_code'] . ' - ' . $row['shift_name'], ' -'),
                    $row['status'],
                    $row['start_at'],
                    $row['end_at'],
                    $row['hours_decimal'],
                ]);
            });

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Cache-Control' => 'no-store, no-cache',
        ]);
    }

    public function pdf(ServiceReportFilterRequest $request): Response
    {
        $report = $this->reportService->build($request->validated(), [
            'hospital_service_ids' => $this->userScopeService->managedHospitalServiceIds($request->user()),
        ]);
        $filename = 'mediturno-reporte-servicios-' . $report['filters']['start_date'] . '-' . $report['filters']['end_date'] . '.pdf';

        return Pdf::loadView('admin.reports.pdf', [
            'report' => $report,
            'generatedAt' => now()->format('Y-m-d H:i'),
        ])
            ->setPaper('letter')
            ->download($filename);
    }
}
