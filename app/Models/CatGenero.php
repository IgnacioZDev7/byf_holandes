<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatGenero extends Model
{
    use HasFactory;

    protected $table = 'cat_generos';

    protected $fillable = [
        'nombre',
    ];

    public $timestamps = false;
}