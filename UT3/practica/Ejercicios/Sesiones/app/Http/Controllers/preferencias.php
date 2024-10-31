<?php

namespace App\Http\Controllers;

use App\Models\ZonasHorarias;
use App\Models\Idiomas;

class preferencias extends Controller
{
    public function index() {
        return view("preferencias", ["idiomas" => Idiomas::getIdiomas(), "zonasHorarias" => ZonasHorarias::getZonasHorarias()]);
    }
}
