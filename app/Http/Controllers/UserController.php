<?php

namespace App\Http\Controllers;

use App\Models\Especialidad;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use App\Mail\NewUserPassword;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::with('roles', 'especialidad');

        // Filtros
        if ($request->filled('role')) {
            $query->whereHas('roles', function($q) use ($request) {
                $q->where('name', $request->role);
            });
        }

        if ($request->filled('especialidad_id')) {
            $query->where('especialidad_id', $request->especialidad_id);
        }

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

        if ($request->filled('fecha_desde')) {
            $query->whereDate('created_at', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('created_at', '<=', $request->fecha_hasta);
        }

        $users = $query->paginate(15)->withQueryString();

        // Datos para los filtros
        $roles = Role::orderBy('name')->get();
        $especialidades = Especialidad::orderBy('nombre')->get();

        return view('users.index', compact('users', 'roles', 'especialidades'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->formResponse(new User(), 'create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);
        $plainPassword = Str::password(12);
        $roleIds = $data['roles'] ? [$data['roles']] : [];

        $user = User::create([
            'nombre' => $data['nombre'],
            'apellido_paterno' => $data['apellido_paterno'],
            'apellido_materno' => $data['apellido_materno'] ?? null,
            'ci' => $data['ci'] ?? null,
            'email' => $data['email'],
            'telefono' => $data['telefono'] ?? null,
            'especialidad_id' => $data['especialidad_id'] ?? null,
            'area_trabajo' => $data['area_trabajo'] ?? null,
            'password' => Hash::make($plainPassword),
        ]);

        $user->syncRoles($roleIds ? Role::whereIn('id', $roleIds)->get() : []);

        Mail::to($user->email)->send(new NewUserPassword($user, $plainPassword));

        return redirect()->route('users.index')->with('status', "Usuario creado. Contraseña: {$plainPassword}");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return $this->formResponse($user, 'edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $this->validateData($request, $user->id);
        $roleIds = $data['roles'] ? [$data['roles']] : [];

        $user->fill([
            'nombre' => $data['nombre'],
            'apellido_paterno' => $data['apellido_paterno'],
            'apellido_materno' => $data['apellido_materno'] ?? null,
            'ci' => $data['ci'] ?? null,
            'email' => $data['email'],
            'telefono' => $data['telefono'] ?? null,
            'especialidad_id' => $data['especialidad_id'] ?? null,
            'area_trabajo' => $data['area_trabajo'] ?? null,
        ]);

        $user->save();

        $user->syncRoles($roleIds ? Role::whereIn('id', $roleIds)->get() : []);

        return redirect()->route('users.index')->with('status', 'Usuario actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        // Evitar que el usuario se elimine a sí mismo.
        if (auth()->id() === $user->id) {
            return back()->with('status', 'No puedes eliminar tu propio usuario.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('status', 'Usuario eliminado');
    }

    /**
     * Shared form response.
     */
    protected function formResponse(User $user, string $mode)
    {
        $especialidades = Especialidad::orderBy('nombre')->get();
        $roles = Role::orderBy('name')->get();

        return view('users.form', compact('user', 'especialidades', 'roles', 'mode'));
    }

    /**
     * Validate incoming data.
     */
    protected function validateData(Request $request, ?int $userId = null): array
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
            'especialidad_id' => ['nullable', 'exists:especialidades,id'],
            'area_trabajo' => ['nullable', 'string', 'max:100'],
            'roles' => ['nullable', 'exists:roles,id'],
        ]);
    }
}
