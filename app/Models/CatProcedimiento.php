<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatProcedimiento extends Model
{
    use HasFactory;

    protected $table = 'cat_procedimientos';

    protected $fillable = [
        'codigo',
        'nombre',
        'area',
        'activa',
    ];
}
