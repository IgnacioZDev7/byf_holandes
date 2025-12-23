<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta #{{ $consulta->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; color: #2d3748; background: #f5f7fa; }
        .card { background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.05); }
        .header { border-bottom: 2px solid #0a7c7b; padding-bottom: 10px; margin-bottom: 16px; }
        .header h1 { margin: 0; color: #0a7c7b; font-size: 22px; }
        .pill { display: inline-block; padding: 6px 10px; border-radius: 6px; background: #edf2f7; font-weight: bold; font-size: 12px; color: #2d3748; margin-top: 6px; }
        .section-title { margin: 14px 0 8px; font-size: 14px; border-left: 4px solid #0a7c7b; padding-left: 8px; color: #2d3748; }
        .grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px 16px; }
        .item { font-size: 13px; line-height: 1.4; }
        .label { font-weight: bold; color: #4a5568; }
        .value { color: #1a202c; }
        .notes { background: #f7fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 10px; font-size: 13px; }
    </style>
</head>
<body>
    <div class="card">
        <div class="header">
            <h1>Consulta Médica</h1>
            <div class="pill">#{{ $consulta->id }}</div>
        </div>

        <div class="section">
            <div class="section-title">Datos principales</div>
            <div class="grid">
                <div class="item"><span class="label">Fecha:</span> <span class="value">{{ $consulta->fecha }}</span></div>
                <div class="item"><span class="label">Hora:</span> <span class="value">{{ $consulta->hora ?? '-' }}</span></div>
                <div class="item"><span class="label">Médico:</span> <span class="value">{{ $consulta->medico?->nombre ?? '-' }} {{ $consulta->medico?->apellido_paterno }}</span></div>
                <div class="item"><span class="label">Paciente:</span> <span class="value">{{ $consulta->paciente?->nombre ?? '-' }} {{ $consulta->paciente?->apellido_paterno }}</span></div>
                <div class="item"><span class="label">Motivo:</span> <span class="value">{{ $consulta->motivo }}</span></div>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Signos vitales y medidas</div>
            <div class="grid">
                <div class="item"><span class="label">Presión:</span> <span class="value">{{ $consulta->presion_arterial ?? '-' }}</span></div>
                <div class="item"><span class="label">Temperatura:</span> <span class="value">{{ $consulta->temperatura ? $consulta->temperatura . '°C' : '-' }}</span></div>
                <div class="item"><span class="label">FC:</span> <span class="value">{{ $consulta->frecuencia_cardiaca ? $consulta->frecuencia_cardiaca . ' bpm' : '-' }}</span></div>
                <div class="item"><span class="label">FR:</span> <span class="value">{{ $consulta->frecuencia_respiratoria ? $consulta->frecuencia_respiratoria . ' rpm' : '-' }}</span></div>
                <div class="item"><span class="label">Peso:</span> <span class="value">{{ $consulta->peso ? $consulta->peso . ' kg' : '-' }}</span></div>
                <div class="item"><span class="label">Talla:</span> <span class="value">{{ $consulta->talla ? $consulta->talla . ' m' : '-' }}</span></div>
                <div class="item"><span class="label">IMC:</span> <span class="value">{{ $consulta->imc ? number_format($consulta->imc, 2) : '-' }}</span></div>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Contenido clínico</div>
            <p><strong>Diagnóstico:</strong><br>{{ $consulta->diagnostico ?? '-' }}</p>
            <p><strong>Tratamiento:</strong><br>{{ $consulta->tratamiento ?? '-' }}</p>
            <p><strong>Indicaciones al paciente:</strong><br>{{ $consulta->indicaciones_paciente ?? '-' }}</p>
            <p><strong>Evolución:</strong><br>{{ $consulta->evolucion ?? '-' }}</p>
            <div class="notes"><strong>Notas adicionales:</strong><br>{{ $consulta->notas_adicionales ?? 'Sin notas adicionales' }}</div>
        </div>

        <div class="section">
            <div class="section-title">Procedimientos</div>
            @if($consulta->procedimientos->isEmpty())
                <p class="value">Sin procedimientos asociados.</p>
            @else
                <ul>
                    @foreach($consulta->procedimientos as $proc)
                        <li>{{ $proc->codigo }} - {{ $proc->nombre }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</body>
</html>
