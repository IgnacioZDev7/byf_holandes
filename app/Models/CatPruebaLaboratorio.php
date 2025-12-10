<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatPruebaLaboratorio extends Model
{
    use HasFactory;

    protected $table = 'cat_pruebas_laboratorio';

    protected $fillable = [
        'categoria_id',
        'nombre',
        'descripcion',
        'activa',
    ];

    public $timestamps = false;

    public function categoria()
    {
        return $this->belongsTo(CatCategoriaPrueba::class, 'categoria_id');
    }
}
