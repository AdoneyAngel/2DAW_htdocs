<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanNutricional extends Model
{
    /** @use HasFactory<\Database\Factories\PlanesNutricionalesFactory> */
    use HasFactory;
    protected $table = 'planesnutricionales';
}
