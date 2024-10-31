<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class login extends Controller
{
    public function index() {
        return view("login");
    }

    public function login(Request $request) {
        //Validar los campos
        if ($request->has("user") && $request->has("pass")) {
            //Validar el contenido de los campos
            $user = $request->get("user");
            $pass = $request->get("pass");

            if (!empty($user) && !empty($pass)) {
                $userModel = new User($user, $pass);

                if ($userModel->login()) {//Se crea una sesion si el usuario es válido
                    Session::put("name", $userModel->getName());
                    Session::put("login", true);

                    return redirect()->route("main");

                } else {
                    return view("login", ["message" => "No se ha podido inicar sesion, los campos son incorrectos"]);
                }

            } else {
                return view("login", ["message" => "No pueden haber campos vacíos"]);
            }

        } else {
            return view("login", ["message" => "No pueden haber campos vacíos"]);
        }
    }

    public function logout() {
        Session::flush();

        return redirect()->route("main");
    }
}
