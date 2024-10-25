<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserProfile extends Controller
{
    public function index($id) {
        $usuario = [
            'name' => "Nombre de usuario",
            'id' => $id
        ];
        return view("users.profile", ['dato' => $usuario]);
    }
}
