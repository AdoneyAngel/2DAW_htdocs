<?php

require_once "../Model/GestorHorario.php";

class HorarioController{

    private $gestorHorario;

    function __construct(){
        $this->gestorHorario = new GestorHorario();

        try {
            if (isset($_POST['insertar'])) {

            }

            if (isset($_POST['eliminar'])) {

            }

            if (isset($_POST['cargar'])) {
         
            }

            if (isset($_POST['generar'])){
        
            }
        } catch (Exception $e) {
            echo '<p style="color:red">Excepción: ', $e->getMessage(), "</p><br>";
        }
    }

    function mostrarHorario(){

    }
}