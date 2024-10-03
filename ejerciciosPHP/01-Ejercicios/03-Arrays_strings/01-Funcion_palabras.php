<?php

/* 
Se desea crear una función que genere palabras al azar con tamaños dinámicos y sin repetición. Si se genera una palabra
que ya se encontrase en el array resultante, no se añade al array y en su lugar se muestra un texto de color rojo:
"<p style='color:red'>La palabra .... está repetida, no se añade </p><br>";

El nombre de la función debe ser: generarPalabras y tendrá tres parámetros.
$caracteres: dónde se incluiran en forma de string todos los caracteres que se van a combinar.
$tamMaxPalabra: dónde se determina el tamaño de las palabras a generar (Todas las palabras generadas serán de tamaño fijo).
$numeroPalabras: el número de palabras a generar.

La función debe devolver un array con las palabras generadas.

function generarPalabras($caracteres, $tamMaxPalabra, $numeroPalabras)

Crear otra función para mostrar por pantalla las palabras generadas denominada: 

function visualizar($palabras)

*/

function generarPalabras($caracteres, $tamMaxPalabra, $numeroPalabras)
{
   $palabras = [];

   for ($wordIndex = 0; $wordIndex < $numeroPalabras; $wordIndex++) {
    $newWord = "";


    for ($charIndex = 0; $charIndex < $tamMaxPalabra; $charIndex++) {
        $newChar = "";
        $newChar = $caracteres[rand(0, strlen($caracteres)-1)];

        $newWord = $newWord.$newChar;
    }

    if (!in_array($newWord, $palabras)) {
        $palabras[] = $newWord;

    } else {
        echo "<p style='color:red'>La palabra $newWord está repetida, no se añade </p><br>";
    }
   }

   return $palabras;
}

function visualizar($palabras)
{
    foreach ($palabras as $palabra) {
        echo "-> $palabra <br>";
    }
}

$caracteres = 'ABCDEFGHIJKLMNÑOPQRSTUVWXYZabcdefghijklmnñopqrstuvwxyz1234567890';
visualizar(generarPalabras($caracteres, 4, 10));
