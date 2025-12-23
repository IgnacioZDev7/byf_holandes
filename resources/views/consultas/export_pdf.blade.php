<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Consultas</title>
    @php use Illuminate\Support\Str; @endphp
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; color: #2d3748; }
        h2 { color: #0f766e; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        th, td { border: 1px solid #e2e8f0; padding: 6px; text-align: left; }
        th { background: #f1f5f9; }
    </style>
</head>
<body>
    <h2>Reporte de Consultas</h2>
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Médico</th>
                <th>Paciente</th>
                <th>Motivo</th>
                <th>Diagnóstico</th>
                <th>Tratamiento</th>
            </tr>
        </thead>
        <tbody>
            @foreach($consultas as $c)
                <tr>
                    <td>{{ $c->fecha }}</td>
                    <td>{{ $c->hora ?? '-' }}</td>
                    <td>{{ $c->medico?->nombre }} {{ $c->medico?->apellido_paterno }}</td>
                    <td>{{ $c->paciente?->nombre }} {{ $c->paciente?->apellido_paterno }}</td>
                    <td>{{ $c->motivo }}</td>
                    <td>{{ Str::limit($c->diagnostico, 50) }}</td>
                    <td>{{ Str::limit($c->tratamiento, 50) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
