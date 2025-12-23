@extends('adminlte::page')

@section('title', 'Inicio')

@section('content')
    @php
        use Illuminate\Support\Facades\DB;
        use App\Models\PacienteProfile;
        use App\Models\ConsultaMedica;
        use App\Models\FichaTurno;

        $turnosEstados = FichaTurno::select('estado', DB::raw('count(*) as total'))
            ->groupBy('estado')
            ->pluck('total', 'estado')
            ->toArray();

        $consultasSemana = ConsultaMedica::select(DB::raw('DATE(fecha) as fecha'), DB::raw('count(*) as total'))
            ->where('fecha', '>=', now()->subDays(6)->toDateString())
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->pluck('total', 'fecha')
            ->toArray();

        $fechasLabels = collect(range(0,6))->map(function($i){
            return now()->subDays(6-$i)->toDateString();
        });
        $consultasData = $fechasLabels->map(fn($f) => $consultasSemana[$f] ?? 0);

        $generos = PacienteProfile::with('genero')
            ->select('genero_id', DB::raw('count(*) as total'))
            ->groupBy('genero_id')
            ->get()
            ->map(function($item){
                return [
                    'label' => $item->genero->nombre ?? 'No definido',
                    'total' => $item->total,
                ];
            });
    @endphp

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="mr-3">
                            <span class="badge badge-success p-2">Sesión activa</span>
                        </div>
                        <div>
                            <h4 class="mb-0 text-teal">Hola, {{ auth()->user()->nombre ?? 'Usuario' }}</h4>
                            <small class="text-muted">Panel principal del Hospital Salud</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="p-3 rounded bg-white shadow-sm h-100">
                                <h5 class="text-teal mb-2"><i class="fas fa-user-injured mr-2"></i>Pacientes</h5>
                                <p class="text-muted mb-3">Administra el registro y seguimiento de pacientes.</p>
                                <a href="{{ route('pacientes.index') }}" class="btn btn-sm btn-outline-primary">Ir a pacientes</a>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="p-3 rounded bg-white shadow-sm h-100">
                                <h5 class="text-teal mb-2"><i class="fas fa-stethoscope mr-2"></i>Consultas</h5>
                                <p class="text-muted mb-3">Registra consultas, signos vitales y procedimientos.</p>
                                <a href="{{ route('consultas.index') }}" class="btn btn-sm btn-outline-primary">Ir a consultas</a>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="p-3 rounded bg-white shadow-sm h-100">
                                <h5 class="text-teal mb-2"><i class="fas fa-notes-medical mr-2"></i>Historial médico</h5>
                                <p class="text-muted mb-3">Consulta y actualiza antecedentes y tratamientos.</p>
                                <a href="{{ route('historial-medico.index') }}" class="btn btn-sm btn-outline-primary">Ir a historial</a>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="p-3 rounded bg-white shadow-sm h-100">
                                <h5 class="text-teal mb-2"><i class="fas fa-calendar-check mr-2"></i>Turnos</h5>
                                <p class="text-muted mb-3">Gestiona turnos y emite fichas PDF.</p>
                                <a href="{{ route('turnos.index') }}" class="btn btn-sm btn-outline-primary">Ir a turnos</a>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="p-3 rounded bg-white shadow-sm h-100">
                                <h5 class="text-teal mb-2"><i class="fas fa-prescription-bottle mr-2"></i>Recetas</h5>
                                <p class="text-muted mb-3">Emite y gestiona tratamientos y medicamentos.</p>
                                <a href="{{ route('recetas.index') }}" class="btn btn-sm btn-outline-primary">Ir a recetas</a>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="p-3 rounded bg-white shadow-sm h-100">
                                <h5 class="text-teal mb-2"><i class="fas fa-vials mr-2"></i>Laboratorio</h5>
                                <p class="text-muted mb-3">Órdenes, pruebas y resultados de laboratorio.</p>
                                <a href="{{ route('laboratorio.ordenes.index') }}" class="btn btn-sm btn-outline-primary">Ir a laboratorio</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-body d-flex align-items-center">
                    <div class="mr-3">
                        <i class="fas fa-user-circle fa-3x text-teal"></i>
                    </div>
                    <div>
                        <h5 class="mb-1">{{ auth()->user()->nombre ?? 'Usuario' }} {{ auth()->user()->apellido_paterno ?? '' }}</h5>
                        <small class="text-muted d-block">{{ auth()->user()->email ?? '' }}</small>
                        <form action="{{ route('logout') }}" method="POST" class="mt-2">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-sign-out-alt"></i> Cerrar sesión
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-header bg-white">
                    <h5 class="mb-0 text-teal">Turnos por estado</h5>
                </div>
                <div class="card-body">
                    <canvas id="chartTurnos" height="180"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-header bg-white">
                    <h5 class="mb-0 text-teal">Consultas últimos 7 días</h5>
                </div>
                <div class="card-body">
                    <canvas id="chartConsultas" height="180"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-header bg-white">
                    <h5 class="mb-0 text-teal">Pacientes por género</h5>
                </div>
                <div class="card-body">
                    <canvas id="chartGeneros" height="180"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const turnosEstados = @json($turnosEstados);
    const consultasLabels = @json($fechasLabels->toArray());
    const consultasData = @json($consultasData->toArray());
    const generosData = @json($generos);

    const palette = ['#0f766e', '#0ea5e9', '#14b8a6', '#f59e0b', '#ef4444'];

    new Chart(document.getElementById('chartTurnos'), {
        type: 'doughnut',
        data: {
            labels: Object.keys(turnosEstados),
            datasets: [{
                data: Object.values(turnosEstados),
                backgroundColor: palette,
            }]
        },
        options: {responsive: true, maintainAspectRatio: false}
    });

    new Chart(document.getElementById('chartConsultas'), {
        type: 'bar',
        data: {
            labels: consultasLabels,
            datasets: [{
                label: 'Consultas',
                data: consultasData,
                backgroundColor: '#0ea5e9'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {y: {beginAtZero: true, precision:0}}
        }
    });

    new Chart(document.getElementById('chartGeneros'), {
        type: 'pie',
        data: {
            labels: generosData.map(g => g.label),
            datasets: [{
                data: generosData.map(g => g.total),
                backgroundColor: palette,
            }]
        },
        options: {responsive: true, maintainAspectRatio: false}
    });
</script>
@endsection
