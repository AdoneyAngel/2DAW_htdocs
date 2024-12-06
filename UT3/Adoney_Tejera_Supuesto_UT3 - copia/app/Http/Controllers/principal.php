<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class principal extends Controller
{
    public function index() {
        $rutaFichero = Storage::disk("xml")->path("empleados.xml");
        $rutaXsd = Storage::disk("xml")->path("departamento.xsd");

        return response(true);
    }
}
