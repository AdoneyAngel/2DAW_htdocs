<?php

namespace App\Models\ejercicio3;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProductoEj3 extends Model
{
    static public function getProductos() {
        $ficheroProductos = Storage::disk("xml")->get("productos.xml");

        $ficheroXml = simplexml_load_string($ficheroProductos);

        $productosXml = $ficheroXml->xpath("//producto");

        $productos = [];


        foreach ($productosXml as $productoActual) {
            $producto = array();


            $detallesXml = $productoActual->detalles[0];

            $detalles = [];

            foreach ($productoActual as $attributo => $valor) {
                $producto[$attributo] = (string)$valor;
            }

            //Cargar detalles del producto
            foreach ($detallesXml as $attributo => $valor) {
                $detalles[$attributo] = (string) $valor;
            }

            $producto["detalles"] = $detalles;

            $productos[] = $producto;
        }

        return $productos;
    }

    static public function buscarProducto($id) {
        if ($id) {
            try {
                $ficheroProductos = Storage::disk("xml")->get("productos.xml");
                $ficheroXml = simplexml_load_string($ficheroProductos);

                $productoXml = $ficheroXml->xpath("//producto[id='$id']");

                $existe = false;

                $producto = array();

                foreach ($productoXml[0] as $atributos => $valor) {
                    $producto[$atributos] = (string) $valor;
                    $existe = true;
                }

                if ($existe) {
                    return $producto;

                } else {
                    return false;
                }

            } catch (\Exception $err) {
                return false;
            }

        } else {
            throw new \Exception("Falta el parámetro ID");
        }
    }

    static function getDetalles($id) {
        if ($id) {
            $ficheroProductos = Storage::disk("xml")->get("productos.xml");
            $ficheroXml = simplexml_load_string($ficheroProductos);

            $productoXml = $ficheroXml->xpath("//producto[id='$id']//detalles");

            $producto = array("id" => $id);

            if (!isset($productoXml[0])) {
                return false;
            }

            foreach ($productoXml[0] as $atributos => $valor) {
                $producto[$atributos] = (string) $valor;
            }

            return $producto;

        } else {
            throw new \Exception("Falta el parámetro ID");
        }
    }
}
