<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Especialidad;

class FichaTurno extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ficha_turno';

    public $timestamps = false;

    protected $fillable = [
        'paciente_id',
        'medico_id',
        'especialidad_id',
        'emision',
        'motivo',
        'estado',
        'observaciones',
        'created_at',
    ];

    protected $casts = [
        'emision' => 'datetime',
        'created_at' => 'datetime',
    ];

    public function paciente()
    {
        return $this->belongsTo(User::class, 'paciente_id');
    }

    public function medico()
    {
        return $this->belongsTo(User::class, 'medico_id');
    }

    public function especialidad()
    {
        return $this->belongsTo(Especialidad::class, 'especialidad_id');
    }
}
