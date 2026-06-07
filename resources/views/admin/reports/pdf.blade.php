<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Reporte de Turnos - MediTurno</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            color: #111827;
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            line-height: 1.35;
            margin: 0;
        }

        h1 {
            font-size: 18px;
            margin: 0 0 6px;
        }

        h2 {
            border-bottom: 1px solid #d1d5db;
            font-size: 13px;
            margin: 18px 0 8px;
            padding-bottom: 4px;
        }

        table {
            border-collapse: collapse;
            margin-top: 8px;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #d1d5db;
            padding: 5px;
            vertical-align: top;
        }

        th {
            background: #f3f4f6;
            font-weight: bold;
            text-align: left;
        }

        .muted {
            color: #6b7280;
        }

        .meta {
            margin-bottom: 14px;
        }

        .summary {
            margin-top: 12px;
        }

        .summary td {
            width: 25%;
        }

        .summary-value {
            display: block;
            font-size: 15px;
            font-weight: bold;
            margin-top: 3px;
        }

        .nowrap {
            white-space: nowrap;
        }
    </style>
</head>
<body>
    @php
        $filters = $report['filters'];
        $summary = $report['summary'];
        $grouped = $report['grouped'];
        $details = $report['details'];
    @endphp

    <h1>Reporte de Turnos - MediTurno</h1>

    <div class="meta">
        <div><strong>Rango de fechas:</strong> {{ $filters['start_date'] }} al {{ $filters['end_date'] }}</div>
        <div><strong>Agrupado por:</strong> {{ $filters['group_by'] === 'staff' ? 'Empleado' : 'Servicio' }}</div>
        <div><strong>Fecha de generación:</strong> {{ $generatedAt }}</div>
    </div>

    <h2>Resumen general</h2>
    <table class="summary">
        <tr>
            <td>
                <span class="muted">Total de turnos</span>
                <span class="summary-value">{{ $summary['assignments_count'] }}</span>
            </td>
            <td>
                <span class="muted">Total de horas</span>
                <span class="summary-value">{{ $summary['total_duration'] }}</span>
                <span class="muted">{{ number_format($summary['total_hours_decimal'], 2) }} h</span>
            </td>
            <td>
                <span class="muted">Servicios incluidos</span>
                <span class="summary-value">{{ $summary['services_count'] }}</span>
            </td>
            <td>
                <span class="muted">Personal incluido</span>
                <span class="summary-value">{{ $summary['staff_count'] }}</span>
            </td>
        </tr>
    </table>

    <h2>Tabla agrupada por {{ $filters['group_by'] === 'staff' ? 'empleado' : 'servicio' }}</h2>
    <table>
        <thead>
            <tr>
                <th>{{ $filters['group_by'] === 'staff' ? 'Empleado' : 'Servicio' }}</th>
                <th class="nowrap">Turnos</th>
                <th class="nowrap">Horas</th>
                <th class="nowrap">Personal</th>
                <th>Desglose por turno</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($grouped as $row)
                <tr>
                    <td>
                        <strong>{{ $row['label'] }}</strong>
                        @if ($row['secondary'])
                            <br><span class="muted">{{ $row['secondary'] }}</span>
                        @endif
                    </td>
                    <td>{{ $row['assignments_count'] }}</td>
                    <td>{{ $row['total_duration'] }}<br><span class="muted">{{ number_format($row['total_hours_decimal'], 2) }} h</span></td>
                    <td>{{ $row['staff_count'] }}</td>
                    <td>
                        @foreach ($row['shift_breakdown'] as $shift)
                            {{ $shift['shift_name'] }}: {{ $shift['assignments_count'] }} / {{ $shift['total_duration'] }}@if (! $loop->last); @endif
                        @endforeach
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="muted">No hay datos para el rango seleccionado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <h2>Tabla detalle de asignaciones</h2>
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Personal</th>
                <th>Servicio</th>
                <th>Turno</th>
                <th>Estado</th>
                <th>Inicio</th>
                <th>Fin</th>
                <th>Duración</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($details as $row)
                <tr>
                    <td>{{ $row['assignment_date'] }}</td>
                    <td>{{ $row['staff_name'] }}<br><span class="muted">{{ $row['staff_ci'] }}</span></td>
                    <td>{{ $row['hospital_service_name'] }}</td>
                    <td>{{ trim($row['shift_code'] . ' - ' . $row['shift_name'], ' -') }}</td>
                    <td>{{ $row['status'] }}</td>
                    <td class="nowrap">{{ $row['start_at'] }}</td>
                    <td class="nowrap">{{ $row['end_at'] }}</td>
                    <td>{{ $row['duration'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="muted">No hay asignaciones para mostrar.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
