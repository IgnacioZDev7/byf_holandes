<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial #{{ $registro->id }}</title>
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
            <h1>Historial Médico</h1>
            <div class="pill">#{{ $registro->id }}</div>
        </div>

        <div class="section">
            <div class="section-title">Datos principales</div>
            <div class="grid">
                <div class="item"><span class="label">Fecha:</span> <span class="value">{{ $registro->fecha }}</span></div>
                <div class="item"><span class="label">Paciente:</span> <span class="value">{{ $registro->paciente?->nombre ?? '-' }} {{ $registro->paciente?->apellido_paterno }}</span></div>
                <div class="item"><span class="label">Consulta asociada:</span> <span class="value">{{ $registro->consulta_id ? '#'.$registro->consulta_id : 'N/A' }}</span></div>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Resumen y diagnóstico</div>
            <p><strong>Resumen:</strong><br>{{ $registro->resumen }}</p>
            <p><strong>Diagnóstico:</strong><br>{{ $registro->diagnostico ?? '-' }}</p>
            <p><strong>Tratamiento:</strong><br>{{ $registro->tratamiento ?? '-' }}</p>
        </div>

        <div class="section">
            <div class="section-title">Campos detallados</div>
            <div class="grid">
                <div class="item"><span class="label">Antecedentes personales:</span> <span class="value">{{ $registro->antecedentes_personales ?? '-' }}</span></div>
                <div class="item"><span class="label">Antecedentes familiares:</span> <span class="value">{{ $registro->antecedentes_familiares ?? '-' }}</span></div>
                <div class="item"><span class="label">Hábitos:</span> <span class="value">{{ $registro->habitos ?? '-' }}</span></div>
                <div class="item"><span class="label">Medicamentos actuales:</span> <span class="value">{{ $registro->medicamentos_actuales ?? '-' }}</span></div>
                <div class="item"><span class="label">Alergias:</span> <span class="value">{{ $registro->alergias ?? '-' }}</span></div>
                <div class="item"><span class="label">Vacunas:</span> <span class="value">{{ $registro->vacunas ?? '-' }}</span></div>
                <div class="item"><span class="label">Exámenes físicos:</span> <span class="value">{{ $registro->examenes_fisicos ?? '-' }}</span></div>
                <div class="item"><span class="label">Notas importantes:</span> <span class="value">{{ $registro->notas_importantes ?? '-' }}</span></div>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Notas</div>
            <div class="notes">
                {{ $registro->notas_importantes ?? 'Sin notas adicionales' }}
            </div>
        </div>
    </div>
</body>
</html>
