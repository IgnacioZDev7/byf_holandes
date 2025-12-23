<?php

namespace App\Http\Controllers;

use App\Models\Direccion;
use App\Models\EmergencyContact;
use App\Models\PacienteProfile;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class PacienteController extends Controller
{
    public function index(Request $request)
    {
        $query = User::withTrashed()->with([
            'perfilPaciente.tipoSangre',
            'perfilPaciente.genero',
            'direcciones',
            'emergencyContacts'
        ]);

        // Filtros
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('apellido_paterno', 'like', "%{$search}%")
                  ->orWhere('apellido_materno', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('telefono', 'like', "%{$search}%")
                  ->orWhere('ci', 'like', "%{$search}%");
            });
        }

        if ($request->filled('tipo_sangre')) {
            $query->whereHas('perfilPaciente', function($q) use ($request) {
                $q->where('tipo_sangre_id', $request->tipo_sangre);
            });
        }

        if ($request->filled('genero')) {
            $query->whereHas('perfilPaciente', function($q) use ($request) {
                $q->where('genero_id', $request->genero);
            });
        }

        if ($request->filled('fecha_desde')) {
            $query->whereDate('created_at', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('created_at', '<=', $request->fecha_hasta);
        }

        $pacientes = $query->paginate(15)->withQueryString();

        // Datos para los filtros
        $tiposSangre = \App\Models\CatTipoSangre::all();
        $generos = \App\Models\CatGenero::all();

        return view('pacientes.index', compact('pacientes', 'tiposSangre', 'generos'));
    }

    public function create()
    {
        return $this->formResponse(new User(), new PacienteProfile(), new Direccion(), new EmergencyContact(), 'create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);
        $plainPassword = Str::password(12);

        $user = User::create([
            'nombre' => $data['nombre'],
            'apellido_paterno' => $data['apellido_paterno'],
            'apellido_materno' => $data['apellido_materno'] ?? null,
            'ci' => $data['ci'] ?? null,
            'email' => $data['email'],
            'telefono' => $data['telefono'] ?? null,
            'password' => bcrypt($plainPassword),
        ]);

        $this->syncPerfil($user, $data);
        $this->syncDireccion($user, $data);
        $this->syncContacto($user, $data);

        return redirect()->route('pacientes.index')->with('status', 'Paciente creado');
    }

    public function edit(User $paciente)
    {
        $perfil = $paciente->perfilPaciente ?: new PacienteProfile(['user_id' => $paciente->id]);
        $direccion = $paciente->direcciones->first() ?: new Direccion(['user_id' => $paciente->id]);
        $contacto = $paciente->emergencyContacts->first() ?: new EmergencyContact(['user_id' => $paciente->id]);

        return $this->formResponse($paciente, $perfil, $direccion, $contacto, 'edit');
    }

    public function update(Request $request, User $paciente): RedirectResponse
    {
        $data = $this->validateData($request, $paciente->id, false);

        $paciente->fill([
            'nombre' => $data['nombre'],
            'apellido_paterno' => $data['apellido_paterno'],
            'apellido_materno' => $data['apellido_materno'] ?? null,
            'ci' => $data['ci'] ?? null,
            'email' => $data['email'],
            'telefono' => $data['telefono'] ?? null,
        ]);

        $paciente->save();

        $this->syncPerfil($paciente, $data);
        $this->syncDireccion($paciente, $data);
        $this->syncContacto($paciente, $data);

        return redirect()->route('pacientes.index')->with('status', 'Paciente actualizado');
    }

    public function destroy(User $paciente): RedirectResponse
    {
        if ($paciente->trashed()) {
            $paciente->restore();
            $paciente->perfilPaciente()?->restore();
            $paciente->direcciones()->withTrashed()->restore();
            $paciente->emergencyContacts()->withTrashed()->restore();
            $message = 'Paciente activado';
        } else {
            $paciente->delete();
            $paciente->perfilPaciente()?->delete();
            $paciente->direcciones()->delete();
            $paciente->emergencyContacts()->delete();
            $message = 'Paciente desactivado';
        }

        return redirect()->route('pacientes.index')->with('status', $message);
    }

    protected function formResponse(User $user, PacienteProfile $perfil, Direccion $direccion, EmergencyContact $contacto, string $mode)
    {
        $tiposSangre = \DB::table('cat_tipos_sangre')->orderBy('codigo')->get();
        $nacionalidades = \DB::table('cat_nacionalidades')->orderBy('nombre')->get();
        $estadosCiviles = \DB::table('cat_estados_civiles')->orderBy('nombre')->get();
        $generos = \DB::table('cat_generos')->orderBy('nombre')->get();
        $parentescos = \DB::table('cat_parentescos')->orderBy('nombre')->get();

        return view('pacientes.form', compact(
            'user',
            'perfil',
            'direccion',
            'contacto',
            'tiposSangre',
            'nacionalidades',
            'estadosCiviles',
            'generos',
            'parentescos',
            'mode'
        ));
    }

    protected function validateData(Request $request, ?int $userId = null, bool $passwordRequired = true): array
    {
        return $request->validate([
            'nombre' => ['required', 'string', 'max:100'],
            'apellido_paterno' => ['required', 'string', 'max:100'],
            'apellido_materno' => ['nullable', 'string', 'max:100'],
            'ci' => ['nullable', 'string', 'max:50', Rule::unique('users', 'ci')->ignore($userId)],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($userId),
            ],
            'telefono' => ['nullable', 'string', 'max:20'],
            'tipo_sangre_id' => ['nullable', 'exists:cat_tipos_sangre,id'],
            'nacionalidad_id' => ['nullable', 'exists:cat_nacionalidades,id'],
            'estado_civil_id' => ['nullable', 'exists:cat_estados_civiles,id'],
            'genero_id' => ['nullable', 'exists:cat_generos,id'],
            'alergias' => ['nullable', 'string'],
            'enfermedades_cronicas' => ['nullable', 'string'],
            'observaciones' => ['nullable', 'string'],
            'zona' => ['nullable', 'string', 'max:100'],
            'calle' => ['nullable', 'string', 'max:150'],
            'nro' => ['nullable', 'string', 'max:20'],
            'referencia' => ['nullable', 'string', 'max:255'],
            'contacto_nombre' => ['nullable', 'string', 'max:150'],
            'contacto_telefono' => ['nullable', 'string', 'max:20'],
            'parentesco_id' => ['nullable', 'exists:cat_parentescos,id'],
        ]);
    }

    protected function syncPerfil(User $user, array $data): void
    {
        $user->perfilPaciente()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'tipo_sangre_id' => $data['tipo_sangre_id'] ?? null,
                'nacionalidad_id' => $data['nacionalidad_id'] ?? null,
                'estado_civil_id' => $data['estado_civil_id'] ?? null,
                'genero_id' => $data['genero_id'] ?? null,
                'alergias' => $data['alergias'] ?? null,
                'enfermedades_cronicas' => $data['enfermedades_cronicas'] ?? null,
                'observaciones' => $data['observaciones'] ?? null,
            ]
        );
    }

    protected function syncDireccion(User $user, array $data): void
    {
        if (! ($data['zona'] ?? $data['calle'] ?? $data['nro'] ?? $data['referencia'])) {
            return;
        }

        $user->direcciones()->updateOrCreate(
            [],
            [
                'zona' => $data['zona'] ?? null,
                'calle' => $data['calle'] ?? null,
                'nro' => $data['nro'] ?? null,
                'referencia' => $data['referencia'] ?? null,
            ]
        );
    }

    protected function syncContacto(User $user, array $data): void
    {
        if (! ($data['contacto_nombre'] ?? $data['contacto_telefono'] ?? $data['parentesco_id'])) {
            return;
        }

        $user->emergencyContacts()->updateOrCreate(
            [],
            [
                'nombre' => $data['contacto_nombre'] ?? null,
                'telefono' => $data['contacto_telefono'] ?? null,
                'parentesco_id' => $data['parentesco_id'] ?? null,
            ]
        );
    }
}
