<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ReportFilterRequest;
use App\Models\HospitalService;
use App\Models\ShiftAssignment;
use App\Models\Staff;
use App\Services\ReportService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function __construct(private readonly ReportService $reportService)
    {
    }

    public function index(ReportFilterRequest $request): View
    {
        $this->authorize('viewAny', ShiftAssignment::class);

        $report = $this->reportService->build($request->validated());

        return view('admin.reports.index', [
            'report' => $report,
            'hospitalServices' => $this->hospitalServiceOptions(),
            'staffOptions' => $this->staffOptions(),
        ]);
    }

    public function export(ReportFilterRequest $request): StreamedResponse
    {
        $this->authorize('viewAny', ShiftAssignment::class);

        $report = $this->reportService->build($request->validated());
        $details = $report['details'];
        $filename = 'mediturno-reporte-' . $report['filters']['start_date'] . '-' . $report['filters']['end_date'] . '.csv';

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

    public function pdf(ReportFilterRequest $request): Response
    {
        $this->authorize('viewAny', ShiftAssignment::class);

        $report = $this->reportService->build($request->validated());
        $filename = 'mediturno-reporte-' . $report['filters']['start_date'] . '-' . $report['filters']['end_date'] . '.pdf';

        return Pdf::loadView('admin.reports.pdf', [
            'report' => $report,
            'generatedAt' => now()->format('Y-m-d H:i'),
        ])
            ->setPaper('letter')
            ->download($filename);
    }

    private function hospitalServiceOptions(): Collection
    {
        return HospitalService::query()
            ->where('active', true)
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    private function staffOptions(): Collection
    {
        return Staff::query()
            ->with('hospitalService')
            ->where('active', true)
            ->orderBy('full_name')
            ->get(['id', 'full_name', 'ci', 'hospital_service_id']);
    }
}
