<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatCategoriaPrueba extends Model
{
    use HasFactory;

    protected $table = 'cat_categorias_pruebas';

    protected $fillable = [
        'nombre',
    ];

    public $timestamps = false;
}
