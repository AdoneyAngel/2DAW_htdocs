<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>Horario Docente</title>
</head>

<?php
require_once '../Controller/HorarioController.php';
require_once "../Model/Campos.php";

$controller = new HorarioController();
?>

<body>
    <div class="container">
        <h1 class="text-center">Horario de Clases</h1>

        <div class="row">
            <div class="container col-md-8">
                <table class="table">
                    <thead class="table-dark">
                        <tr>
                            <th>HORA:</th>
                            <th>LUNES</th>
                            <th>MARTES</th>
                            <th>MIERCOLES</th>
                            <th>JUEVES</th>
                            <th>VIERNES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $controller->mostrarHorario();
                        ?>                    
                    </tbody>
                </table>
            </div>
            <br>
            <br>

            <div class="container col-md-4">
                <h5>Operaciones Horario:</h5>

                <form action="#" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-6">
                            <label>Curso:</label>
                            <select class="form-select" id="curso" name="curso">
                                <?php
                                foreach (Curso::cases() as $curso) {
                                    echo "<option value='".$curso->value."'>";
                                        echo $curso->value;
                                    echo "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-6">
                            <label>Día:</label>
                            <select class="form-select" id="dia" name="dia">
                                <?php
                                foreach (Semana::cases() as $dia) {
                                    echo "<option value='".$dia->value."'>";
                                        echo $dia->name;
                                    echo "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <label>Tipo:</label>
                            <select class="form-select" id="tipoFranja" name="tipoFranja">
                                <?php
                                foreach (TipoFranja::cases() as $tipo) {
                                    echo "<option value='".$tipo->value."'>";
                                        echo $tipo->name;
                                    echo "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-6">
                            <label>Hora:</label>
                            <select class="form-select" id="hora" name="hora">
                                <?php
                                foreach (Hora::cases() as $hora) {
                                    echo "<option value='".$hora->value."'>";
                                        echo $hora->value;
                                    echo "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <label>Materia:</label>
                            <select class="form-select" id="materia" name="materia">
                                <?php
                                foreach (Materia::cases() as $materia) {
                                    echo "<option value='".$materia->value."'>";
                                        echo $materia->name;
                                    echo "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-6">
                            <label>Clase:</label>
                            <select class="form-select" id="clase" name="clase">
                                <?php
                                foreach (Clase::cases() as $clase) {
                                    echo "<option value='".$clase->value."'>";
                                        echo $clase->value;
                                    echo "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label>Color:</label>
                            <select class="form-select" id="color" name="color">
                                <?php
                                foreach (Color::cases() as $color) { //Se evita que pueda seleccionar un color que está reservado para recreos y horas complementarias
                                    if ($color != Color::Azul && $color != Color::AzulClaro) {
                                        echo "<option value='".$color->value."'>";
                                            echo $color->name;
                                        echo "</option>";                                        
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-4">
                            <input type="submit" class="btn btn-primary" name="insertar" value="Insertar Hora">
                        </div>

                        <div class="col-4">
                            <input type="submit" class="btn btn-danger" name="eliminar" value="Eliminar Hora">
                        </div>
                    </div>
                    <br>
                    <h5>Generar Horario:</h5>
                    <div class="row">
                        <div class="col-6">
                            <label>Tipo Horario:</label>
                            <select class="form-select" id="tipohorario" name="tipohorario">
                                <?php
                                foreach (TiposHorarios::cases() as $tipo) {
                                    echo "<option value='".$tipo->value."'>";
                                        echo $tipo->name;
                                    echo "</option>";   
                                }    
                                ?>

                            </select>
                            <br>
                            <input type="submit" class="btn btn-info" name="generar" value="Generar Horario">
                        </div>
                    </div>
                    <br>
                    <h5>Importar Horario:</h5>
                    <div class="row">
                        <div class="col-4">
                            <input type="file" name="fhorario" id="fhorario">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-4">
                            <input type="submit" class="btn btn-warning" name="cargar" value="Cargar Horario">
                        </div>
                    </div>

                </form>

            </div>
        </div>
</body>

</html>