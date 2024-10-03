<?php
/*
Utilizando la clase cliente.php, crea una función denominada generarGruposClientes que dado 10 grupos cree 
y asigne aleatoriamente un número de 1 a 20 clientes, los campos DNI, nombre, apellido, saldo, deberán ser 
aleatorios. La función deberá devolver todos los datos en forma de array.

Realiza además una función denominada "visualizarClientes" en la que le pasaremos el parámetro array generado
con la función anterior. Recorrer la estructura y mostrar por pantalla los datos de los clientes con el siguiente 
formato:
    Grupo Grupo0:
        Numero de Clientes del grupo: 5

            DNI de Cliente: 1111a
            Nombre de Cliente: Yeray
            Apellidos de Cliente: Pérez
            
            DNI de Cliente: ...
*/

require "./cliente.php";

function generarGruposClientes ($grupos) {
    $gruposClientes = null;

    //Generar grupos
    foreach ($grupos as $grupo) {
        //Generar clientes
        $nClientes = rand(2, 5);

        for ($clientIndex = 0; $clientIndex<$nClientes; $clientIndex++) {
            $clientName = genText();
            $clientLastName = genText()." ".genText();
            $clientDNI = genText().genText().genText();
            $clientCuote = rand(1100, 3000);

            $newClient = new Cliente($clientDNI, $clientName, $clientLastName, $clientCuote);

            $gruposClientes[$grupo][] = $newClient;
        }

    }

    return $gruposClientes;

}

function genText() {

    $characters = "abcdefghilmnopqrstuvwxyz";

    $text = "";

    for ($index = 0; $index<5; $index++) {
        $text = $text . $characters[rand(0, strlen($characters)-1)];
    }

    return $text;
}

function visualizarClientes($grupos) {
    foreach ($grupos as $grupo => $clientes) {
        echo "Grupo $grupo <br>";
        echo "___Número de clientes del grupo: ".count($clientes)."<br><br>";

        foreach ($clientes as $cliente) {
            echo "______DNI del cliente: ".$cliente->getDNI()."<br>";
            echo "______Nombre del cliente: ".$cliente->getNombre()."<br>";
            echo "______Saldo del cliente: ".$cliente->getSaldo()."€ <br>";
            echo "______Apellidos del cliente: ".$cliente->getApellido()."<br><br>";
        }
        
    }
}

$grupos = generarGruposClientes([1, 2]);

visualizarClientes($grupos);

?>