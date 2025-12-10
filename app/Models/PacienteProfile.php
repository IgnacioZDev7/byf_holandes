<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PacienteProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tipo_sangre_id',
        'nacionalidad_id',
        'estado_civil_id',
        'genero_id',
        'alergias',
        'enfermedades_cronicas',
        'observaciones',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
