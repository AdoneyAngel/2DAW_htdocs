<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ejercicio extends Model
{
    /** @use HasFactory<\Database\Factories\EjerciciosFactory> */
    use HasFactory;
    protected $table = 'ejercicios';
}
