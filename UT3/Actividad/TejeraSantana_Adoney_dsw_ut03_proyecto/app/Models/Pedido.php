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
                if (empty($item) || $item =="\n") {
                    continue;
                }

                $codigoPedido = self::generarCodigo();
                $isbn = $item["isbn"];
                $unidades = $item["unidades"];
                $usuario = Usuario::getUsuario();

                $dataString = "$codigoPedido#$usuario#$fechaHora#$isbn#$unidades@";

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

    public static function cancelar($codigoPedido) {
        if (!Session::has("Usuario")) {
            throw new \Exception("Debe iniciar sesión.");
        }
        if (self::existePedido($codigoPedido)) {
            $rutaFichero = Storage::disk("datos")->path("pedidos.dat");
            $rutaFicheroTemp = Storage::disk("datos")->path("pedidosTemp.dat");

            $ficheroPedidos = fopen($rutaFichero, "r");
            $ficheroPedidosTemporal = fopen($rutaFicheroTemp, "a");

            $contenidoFicheroTemporal = "";

            try {

                while ($linea = fgets($ficheroPedidos)) {
                    $divisionLinea = explode("#", $linea);

                    if (strlen(trim($divisionLinea[0])) <= 0 || $divisionLinea[0] == "\n") {
                        continue;
                    }

                    $codigoPedidoActual = $divisionLinea[0];

                    if ($codigoPedido != $codigoPedidoActual) {
                        $stringData = $linea."\n";
                        $contenidoFicheroTemporal .= $stringData;
                        fwrite($ficheroPedidosTemporal, $stringData);
                    }

                    if (feof($ficheroPedidos)) {
                        break;
                    }
                }
                fclose($ficheroPedidos);
                fclose($ficheroPedidosTemporal);

                $ficheroPedidos = fopen($rutaFichero, "w");
                $ficheroPedidosTemporal = fopen($rutaFichero, "w");

                fwrite($ficheroPedidos, $contenidoFicheroTemporal);
                fwrite($ficheroPedidosTemporal, "");

            } catch(\Exception $err) {
                throw new \Exception($err->getMessage());

            } finally {
                fclose($ficheroPedidosTemporal);
                fclose($ficheroPedidos);

                return true;
            }

        } else {
            throw new \Exception("No existe el pedido.");
        }
    }

    public static function getPedidos() {
        if (self::existeFichero()) {
            $rutaFichero = Storage::disk("datos")->path("pedidos.dat");

            $fichero = fopen($rutaFichero, "r");

            $pedidos = [];

            while ($linea = fgets($fichero)) {
                $divisionLinea = explode("#", $linea);

                if (strlen(trim($divisionLinea[0])) <= 0 || $divisionLinea[0] == "\n") {
                    continue;
                }

                $divisionLinea[4] = str_replace("@", "", $divisionLinea[4]);//En cada linea hay un "@" final, por lo que se deberá borrar

                $pedidos[] = [
                    "codpedido" => $divisionLinea[0],
                    "usuario" => $divisionLinea[1],
                    "fechapedido" => $divisionLinea[2],
                    "isbn" => $divisionLinea[3],
                    "unidades" => trim($divisionLinea[4])
                ];

                if (feof($fichero)) {
                    break;
                }
            }

            return $pedidos;

        } else {
            return [];
        }
    }

    private static function existePedido($codigo) {
        $pedidos = self::getPedidos();

        foreach ($pedidos as $pedido) {
            if ($pedido["codpedido"] == $codigo) {
                return true;
            }
        }

        return false;
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
                if ($pedido["codpedido"] == $nuevoCodigo) {
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
