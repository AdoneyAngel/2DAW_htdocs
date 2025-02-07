<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UsuariosFactory> */
    use HasFactory, HasApiTokens, Notifiable;
    protected $table = 'usuarios';

    protected $primaryKey = "id_usuario";

    protected $fillable = [
        "email",
        "clave",
        "id_tipo_usuario"
    ];

    const CREATED_AT = 'fecha_registro';

    public function tipoUsuario() {
        return $this->belongsTo(TipoUsuario::class, "id_tipo_usuario");
    }

    public function suscripciones() {
        return $this->hasMany(Suscripcion::class, "id_cliente");
    }

    public function estadisticas() {
        return $this->hasMany(EstadisticaCliente::class, "id_cliente");
    }

    public function perfil() {
        return $this->hasMany(PerfilUsuario::class, "id_usuario");
    }

    public function planesEntrenamiento() {
        return $this->hasMany(PlanEntrenamiento::class, "id_cliente");
    }

    public function planesNutricionales() {
        return $this->hasMany(PlanNutricional::class, "id_cliente");
    }

    public function tablasEntrenamiento() {
        $planes = $this->planesEntrenamiento;
        $tablas = [];

        foreach($planes as $plan) {//Se recorre cada plan del usuario
            foreach($plan->tablasEntrenamiento as $tabla) {//Se recorre cada tabla de cada plan y cada uno se guarda
                $tablas[] = $tabla;
            }
        }

        return $tablas;
    }

    public function series() {
        $tablas = $this->tablasEntrenamiento();
        $series = [];

        foreach($tablas as $tabla) {
            foreach($tabla->series as $serie) {
                $series[] = $serie;
            }
        }

        return $series;

    }

    public function ejercicios() {
        $series = $this->series();
        $ejercicios = [];

        foreach ($series as $serie) {
            $ejercicios[] = $serie->ejercicio;
        }

        return $ejercicios;
    }

    public function entrenadores() {
        $planes = $this->planesEntrenamiento;
        $entrenadores = [];

        foreach($planes as $plan) {
            $entrenadores[] = $plan->entrenador;
        }

        return $entrenadores;
    }

    public function nutricionistas() {
        $planes = $this->planesNutricionales;
        $nutricionistas = [];

        foreach($planes as $plan) {
            $nutricionistas[] = $plan->nutricionista;
        }

        return $nutricionistas;
    }

    public function tiposMusculo() {
        $ejercicios = $this->ejercicios();
        $tipos = [];

        foreach($ejercicios as $ejercicio) {
            $tipos[] = $ejercicio->tipoMusculo;
        }

        return $tipos;
    }

    public static function esCliente(Usuario $usuario) {
        $tipo = TipoUsuario::where("tipo_usuario", "cliente")->first();

        return $usuario->tipoUsuario->id_tipo_usuario == $tipo->id_tipo_usuario;
    }

    public static function esAdmin(Usuario $usuario) {
        $tipo = TipoUsuario::where("tipo_usuario", "administrador")->first();

        return $usuario->tipoUsuario->id_tipo_usuario == $tipo->id_tipo_usuario;
    }

    public static function esEntrenador(Usuario $usuario) {
        $tipo = TipoUsuario::where("tipo_usuario", "entrenador")->first();

        return $usuario->tipoUsuario->id_tipo_usuario == $tipo->id_tipo_usuario;
    }

    public static function esGestor(Usuario $usuario) {
        $tipo = TipoUsuario::where("tipo_usuario", "gestor")->first();

        return $usuario->tipoUsuario->id_tipo_usuario == $tipo->id_tipo_usuario;
    }
}
