<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\CatTipoSangre;
use App\Models\CatGenero;

class PacienteProfile extends Model
{
    use HasFactory, SoftDeletes;

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

    public function tipoSangre()
    {
        return $this->belongsTo(CatTipoSangre::class, 'tipo_sangre_id');
    }

    public function genero()
    {
        return $this->belongsTo(CatGenero::class, 'genero_id');
    }
}
