<?php

namespace App\Http\Controllers;

use App\Models\Xml;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class sessionController extends Controller
{
    public function login(Request $request) {

        //Obtener usuarios del XML
        $users = Xml::getUsers();

        //Se recorre los usuarios en busca de una coincidencia
        $login = false;
        foreach ($users as $user) {
            if ($user->name == $request->user && $user->password == $request->password) {
                $login = true;
            }
        }

        if ($login) {
            Session::put('user', $request->user);

            return response(json_encode(["login" => $login, "redirect" => "/"]));

        } else {
            return response(json_encode(["login" => $login]));
        }



    }

    public function index() {
        return view("login");
    }

    public function logout() {
        Session::flush();

        return redirect()->route("login");
    }
}
