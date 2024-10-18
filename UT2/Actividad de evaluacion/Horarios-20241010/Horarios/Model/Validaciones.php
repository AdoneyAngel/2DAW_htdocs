<?php
function validarFicheroDatos() {
    $rutaDatos = "../Horarios/horarios.dat";

    if (!file_exists($rutaDatos)) {
        validarCarpetaDatos();

        $ficheroDatos = fopen($rutaDatos, "w");
        fclose($ficheroDatos);

        return true;
    }

    return true;
}

function validarCarpetaDatos() {
    $rutaCarpetaDatos = "../Horarios/";

    if(!is_dir($rutaCarpetaDatos)) {
        mkdir($rutaCarpetaDatos);
        
    }

    return true;
}

function validarCarpetaDatosTemporales () {
    $rutaCarpetaTemporal = "../datos_temporales/";

    if(!is_dir($rutaCarpetaTemporal)) {
        mkdir($rutaCarpetaTemporal);
    }

    return true;
}

function validarDatosInsertar() {
    if (isset($_POST["curso"]) && isset($_POST["dia"]) && isset($_POST["tipoFranja"]) && isset($_POST["color"]) && isset($_POST["clase"]) && isset($_POST["materia"]) && isset($_POST["hora"])) {
        if (!empty($_POST["curso"]) && !empty($_POST["dia"]) && !empty($_POST["tipoFranja"]) && !empty($_POST["color"]) && !empty($_POST["clase"]) && !empty($_POST["materia"]) && !empty($_POST["hora"])) {
            return true;
            
        } else {
            return false;
        }

    } else {
        return false;
    }
}

function validarDatosEliminar() {
    if (isset($_POST["dia"]) && isset($_POST["hora"])) {
        if (!empty($_POST["dia"]) && !empty($_POST["hora"])){
            return true;
        }

    }

    return false;
}

function validarDatosGenerar() {
    if (isset($_POST["tipohorario"])) {
        if (!empty($_POST["tipohorario"])) {
            return true;

        } else {
            return false;
        }

    } else {
        return false;
    }
}

function validarDatosCargar() {

    if (isset($_FILES["fhorario"])) {//Se ha pasado un fichero
        $ficheroTMP = $_FILES["fhorario"];

        if (is_uploaded_file($ficheroTMP["tmp_name"])) {//se ha subido el fichero
            $contenidoTMP = file_get_contents($ficheroTMP["tmp_name"]);

            if (!empty($contenidoTMP)) {//No está vacio
                validarCarpetaDatosTemporales();
                validarFicheroDatos();
                return true;

            } else {
                return false;
            }

        } else {
            return false;
        }

    } else {
        return false;
    }
}

function franjaLectiva($franja) {
    if ($franja->getTipoFranja() != TipoFranja::Lectiva) {
        return false;

    }

    switch($franja->getModulo()->getMateria()) {
        case Materia::RECREO:
            return false;

        case Materia::COTUTORIA:
            return false;

        case Materia::GUARDIA:
            return false;

        case Materia::REUNIÓN_DEPARTAMENTO:
            return false;

        case Materia::OTRO:
            return false;

        case Materia::TUTORÍA:
            return false;

        default:
            return true;
    }
}

function franjaComplementaria($franja) {
    if ($franja->getTipoFranja() == TipoFranja::Complementaria) {
        return true;
    }

    switch($franja->getModulo()->getMateria()) {
        case Materia::COTUTORIA:
            return true;

        case Materia::GUARDIA:
            return true;

        case Materia::REUNIÓN_DEPARTAMENTO:
            return true;

        case Materia::TUTORÍA:
            return true;

        case Materia::OTRO:
            return true;

        default:
            return false;
    }
}

function materiaLectiva($materia) {
    switch($materia) {
        case Materia::COTUTORIA:
            return true;

        case Materia::GUARDIA:
            return true;

        case Materia::REUNIÓN_DEPARTAMENTO:
            return true;

        case Materia::TUTORÍA:
            return true;

        case Materia::OTRO:
            return true;

        default:
            return false;
    }
}

function franjaRecreo($franja) {
    if ($franja->getTipoFranja() == TipoFranja::Recreo) {
        return true;
    }

    if ($franja->getModulo()->getMateria() == Materia::RECREO) {
        return true;
    }

    return false;
}

function validarInsertarFranja($nuevaFranja, $horario) {
    //El primer bucle se encarga de obtener diferentes datos de varias condiciones, de esta forma se ahorra el ejecutar el mismo bucle muchas veces

    //Variables utilzadas durante la validacion
    $nMismaMateria = 0;
    $nHorasDiaLectivas = 0;
    $nHorasDiaNoLectivas = 0;
    $nHorasSemanaLectivas = 0;
    $nHorasSemanaNoLectivas = 0;
    $nReunionesDepartamento = 0;
    $nHoraTutoria = 0;
    $franjaHoraAnterior = null;
    $franjaHoraSiguiente = null;
    $franja2HoraAnterior = null;
    $franja2HoraSiguiente = null;
    $nHorasComplementariasDia = 0;
    $nHorasComplementariasSemana = 0;
    $maxHorasComplementarias = 5;

    if (!$horario) {
        return true;
    }

    foreach ($horario as $franjaActual) {
        if ($franjaActual->getDia() == $nuevaFranja->getDia() && $franjaActual->getHora() == $nuevaFranja->getHora()) {//#################################1-> Comprobar si la hora ya esta ocupada
            throw new Exception("La franja de hora ya existe, elige otra que esté disponible.");
        }

        if ($franjaActual->getModulo()->getMateria() == $nuevaFranja->getModulo()->getMateria() && $franjaActual->getDia() == $nuevaFranja->getDia() && franjaLectiva($franjaActual) && franjaLectiva($nuevaFranja)) {//2
            $nMismaMateria++;
        }

        if (franjaLectiva($franjaActual) && $franjaActual->getDia() == $nuevaFranja->getDia()) {//3
            $nHorasDiaLectivas++;

        } else if(franjaComplementaria($franjaActual) && $franjaActual->getDia() == $nuevaFranja->getDia()) {//4
            $nHorasComplementariasDia++;
        }

        if (franjaLectiva($franjaActual)) {//5
            $nHorasSemanaLectivas++;

        }
        if (franjaComplementaria($franjaActual)){//6
            $nHorasComplementariasSemana++;
        }

        if ($franjaActual->getModulo()->getMateria() == Materia::REUNIÓN_DEPARTAMENTO) {//8
            $nReunionesDepartamento++;
            $maxHorasComplementarias = 6;
        }

        if ($franjaActual->getModulo()->getMateria() == Materia::TUTORÍA) {//10
            $nHoraTutoria++;
        }

        if ($franjaActual->getHora()->codigoHora() == $nuevaFranja->getHora()->codigoHora()+1 && $franjaActual->getDia() == $nuevaFranja->getDia()) {//11
            $franjaHoraSiguiente = $franjaActual;
        }

        if ($franjaActual->getHora()->codigoHora() == $nuevaFranja->getHora()->codigoHora()-1 && $franjaActual->getDia() == $nuevaFranja->getDia()) {//11
            $franjaHoraAnterior = $franjaActual;
        }

        if ($franjaActual->getHora()->codigoHora() == $nuevaFranja->getHora()->codigoHora()-2 && $franjaActual->getDia() == $nuevaFranja->getDia()) {
            $franja2HoraAnterior = $franjaActual;
        }

        if ($franjaActual->getHora()->codigoHora() == $nuevaFranja->getHora()->codigoHora()+2 && $franjaActual->getDia() == $nuevaFranja->getDia()) {
            $franja2HoraSiguiente = $franjaActual;
        }
    }

    //#################################2-> Misma materia maximo 3 dias
    if ($nMismaMateria >= 3) {
        throw new Exception("La franja horaria, ha superado el número de horas por día.");
    }

    //#################################3-> Maximo 5 horas lectivas el mismo dia
    if ($nHorasDiaLectivas >= 5 && franjaLectiva($nuevaFranja)) {
        throw new Exception("El número de horas lectivas durante el día se ha superado.");
    }

    //#################################4-> Maximo 3 horas complementarias el mismo dia
    if ($nHorasComplementariasDia >= 3 && franjaComplementaria($nuevaFranja)) {
        throw new Exception("El número de horas complementarias durante este día se ha superado.");
    }
    
    //#################################5-> Maximo 18 horas lectivas en la semana
    if ($nHorasSemanaLectivas >= 18 && franjaLectiva($nuevaFranja)) {
        throw new Exception("El número de horas lectivas durante la semana se ha superado.");
    }
    
    //#################################6-> Maximo 6 horas complementarias en la semana
    if ($nHorasComplementariasSemana >= $maxHorasComplementarias && franjaComplementaria($nuevaFranja) && $nuevaFranja->getModulo()->getMateria() != Materia::REUNIÓN_DEPARTAMENTO) {
        throw new Exception("El número de horas complementarias durante la semana se ha superado.");
    }
    
    //#################################7-> 1ra hora del martes solo puede ser para Reunion de departamento
    if ($nuevaFranja->getDia() == Semana::Martes && $nuevaFranja->getHora() == Hora::Octava && $nuevaFranja->getModulo()->getMateria() != Materia::REUNIÓN_DEPARTAMENTO) {
        throw new Exception("Esta franja horaria esta reservada únicamente para la hora complementaria 'Reunión de departamento', no se puede establecer.");
    }

    //#################################8-> Solo puede haber 1 hora de reunion de departamento
    if ($nuevaFranja->getModulo()->getMateria() == Materia::REUNIÓN_DEPARTAMENTO && $nReunionesDepartamento) {
        throw new Exception("Ya existe la franja horaria de reunión de departamento.");
    }

    //#################################9-> El horario de recreo solo puede ser ocupado por recreo (cuarta y onceava hora)
    if ($nuevaFranja->getTipoFranja() != TipoFranja::Recreo && ($nuevaFranja->getHora() == Hora::Cuarta || $nuevaFranja->getHora() == Hora::Onceava)) {
        throw new Exception("Esta franja horaria está reservada para los recreos.");
    }

    //#################################10-> Solo puede haber una tutoria
    if ($nuevaFranja->getModulo()->getMateria() == Materia::TUTORÍA && $nHoraTutoria) {
        throw new Exception("La tutoría ya está establecida en el horario semanal.");
    }

    //#################################11-> No pueden haber 3 guardias seguidas
    if ($nuevaFranja->getModulo()->getMateria() == Materia::GUARDIA && $franjaHoraAnterior && $franjaHoraAnterior->getModulo()->getMateria() == Materia::GUARDIA) { //Primero se comprueba si hay una hora de guarda antes

        if ($franjaHoraSiguiente && $franjaHoraSiguiente->getModulo()->getMateria() == Materia::GUARDIA) {//Se comprueba si el siguiente es una guardia
            throw new Exception("Las guardias no pueden establecerse en franjas horarias seguidas.");

        } else if($franja2HoraAnterior && $franja2HoraAnterior->getModulo()->getMateria() == Materia::GUARDIA) {//Se comprueba si justo antes de la hora anterior ya hubo una guardia
            throw new Exception("Las guardias no pueden establecerse en franjas horarias seguidas.");
        }

    } else if($nuevaFranja->getModulo()->getMateria() == Materia::GUARDIA && $franjaHoraSiguiente && $franjaHoraSiguiente->getModulo()->getMateria() == Materia::GUARDIA) {//Se comprueba si la hora posterior hay una guardia
        if ($franjaHoraAnterior && $franjaHoraAnterior->getModulo()->getMateria() == Materia::GUARDIA) {//Se comprueba si antes hubo una guardia
            throw new Exception("Las guardias no pueden establecerse en franjas horarias seguidas.");

        } else if($franja2HoraSiguiente && $franja2HoraSiguiente->getModulo()->getMateria() == Materia::GUARDIA) {//Se comprueba si despues de la siguiente guardia hay otra mas
            throw new Exception("Las guardias no pueden establecerse en franjas horarias seguidas.");
        }
    }

    return true;
}

function validarEliminarFranja($nuevaFranja, $horario) {
    //####################################1-> Se comprueba que la franja existe
    if (!$nuevaFranja) {
        throw new Exception("La hora y el día seleccionado no existe, no se puede eliminar.");
    }
    
    //####################################2-> No se pueden borrar los recreos ni las reuniones de departamento
    if ($nuevaFranja->getModulo()->getMateria() == Materia::REUNIÓN_DEPARTAMENTO || franjaRecreo($nuevaFranja)) {
        throw new Exception("La franja horaria preestablecida, no se puede eliminar.");
    }
    
    //####################################3-> Para poder borrar una tutoria, no pueden haber cotutorias
    foreach ($horario as $franjaActual) {
        if ($franjaActual->getModulo()->getMateria() == Materia::COTUTORIA && $nuevaFranja->getModulo()->getMateria() == Materia::TUTORÍA) {
            throw new Exception("No se puede eliminar la tutoría, se deben eliminar primero el resto de cotutorías.");
        }
    }

    return true;
}