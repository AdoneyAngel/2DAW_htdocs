<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class Pedido extends Model
{
    public static function procesarPedido() {
        self::validarFicheroDatos();

        if (self::existeCarrito()) {
            $carrito = Session::get("Carrito");

            $fechaHora = date("Y:m:d H:i:s");

            foreach ($carrito as $item) {
                $codigoPedido = self::generarCodigo();
                $isbn = $item["isbn"];
                $unidades = $item["unidades"];

                $dataString = "$codigoPedido#$fechaHora#$isbn#$unidades@";

                //Escribir en fichero
                self::guardarPedido($dataString);
            }

            Carrito::vaciar();
            return true;

        } else {
            throw new \Exception("No existe carrito o está vacío.");
        }
    }

    public static function existeCarrito() {
        if (Session::has("Carrito")) {
            $carrito = Session::get("Carrito");

            if (count($carrito) > 0) {
                return true;

            } else {
                return false;
            }

        } else {
            return false;
        }
    }

    public static function getPedidos() {
        if (self::existeFichero()) {
            $rutaFichero = Storage::disk("datos")->path("pedidos.dat");

            $fichero = fopen($rutaFichero, "r");

            $pedidos = [];

            while ($linea = fgets($fichero)) {
                $divisionLinea = explode("#", $linea);//En cada linea hay un "@" final, por lo que se deberá borrar
                $divisionLinea[3] = str_replace("@", "", $divisionLinea[3]);

                $pedidos[] = [
                    "cod" => $divisionLinea[0],
                    "fecha" => $divisionLinea[1],
                    "isbn" => $divisionLinea[2],
                    "unidades" => $divisionLinea[3]
                ];

                if (feof($fichero)) {
                    break;
                }
            }

            return $pedidos;
        }
    }

    private static function guardarPedido($dataString) {
        self::validarFicheroDatos();

        $dataString .= "\n";

        $rutaFichero = Storage::disk("datos")->path("pedidos.dat");

        $fichero = fopen($rutaFichero, "a");
        fwrite($fichero, $dataString);
        fclose($fichero);

        return true;

    }

    private static function generarCodigo() {
        $pedidosRealizados = self::getPedidos();

        $nuevoCodigo = -1;
        $codigoRepetido = true;

        while ($codigoRepetido) {
            $nuevoCodigo++;
            $codigoRepetido = false;

            foreach ($pedidosRealizados as $pedido) {
                if ($pedido["cod"] == $nuevoCodigo) {
                    $codigoRepetido = true;
                }
            }
        }

        return $nuevoCodigo;
    }

    private static function existeFichero() {
        $rutaFichero = Storage::disk("datos")->path("pedidos.dat");

        if (Storage::disk("datos")->exists("pedidos.dat")) {
            return true;
        }

        return false;
    }

    private static function validarFicheroDatos () {//Valida y crea el fichero necesario para los datos
        $rutaFichero = Storage::disk("datos")->path("pedidos.dat");

        if (!self::existeFichero()) {
            $ficheroDatos = fopen($rutaFichero, "w");
            fclose($ficheroDatos);

            return true;

        }

        return true;
    }
}
