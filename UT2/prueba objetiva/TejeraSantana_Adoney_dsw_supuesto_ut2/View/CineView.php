<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

    <title>Sistema de Reservas Sala de Cine</title>
</head>

<body>
    <div class="container">
        <h1 class="text-center">Sistema de Reservas de Sala de Cines</h1>

        <div class="row">
            <div class="container col-md-8">

                <table border="2">
                    <tbody>
                        <tr>
                            <td>Leyenda:</td>
                        </tr>
                        <tr>
                            <td><img src="../Datos/img/ocupado.png" with="30" height="30" alt="ocupado">Asiento Ocupado
                            </td>
                            <td><img src="../Datos/img/reservado.png" with="30" height="30" alt="reservado">Asiento
                                Reservado
                            </td>
                            <td><img src="../Datos/img/libre.png" with="30" height="30" alt="libre">No hay asiento</td>
                        </tr>
                        <tr>
                            <td><img src="../Datos/img/disponible.png" with="30" height="30" alt="disponible">Asiento
                                Disponible
                            </td>
                            <td><img src="../Datos/img/rueda_libre.jpg" with="30" height="30" alt="rueda_libre">Espacio
                                Silla de
                                Ruedas Libre</td>
                            <td><img src="../Datos/img/rueda_ocupada.jpg" with="30" height="30"
                                    alt="rueda_ocupado">Espacio Silla
                                de Ruedas Ocupado</td>
                        </tr>
                    </tbody>
                </table>
                <?php
                // Mostrar la sala al cargar el fichero.
                    require_once "../Model/Enums.php";
                    require_once "../Controller/ProcesarController.php";
                
                    $controller = new ProcesarController();

                ?>
                <!-- Ejemplo tabla vista de la Sala de Cine.
                <table border="2">
                    <tbody>
                        <tr>
                            <th></th>
                            <th>0</th>
                            <th>1</th>
                            <th>2</th>
                            <th>3</th>
                            <th>4</th>
                            <th>5</th>
                            <th>6</th>
                            <th>7</th>
                            <th>8</th>
                            <th>9</th>
                            <th>10</th>
                            <th>11</th>
                            <th>12</th>
                            <th>13</th>
                            <th>14</th>
                            <th>15</th>
                            <th>16</th>
                        </tr>
                        <tr>
                            <td>0</td>
                            <td><img src="img/libre.png" with="30" height="30" alt="libre"></td>
                            <td><img src="img/ocupado.png" with="30" height="30" alt="ocupado"></td>
                            <td><img src="img/ocupado.png" with="30" height="30" alt="ocupado"></td>
                            <td><img src="img/ocupado.png" with="30" height="30" alt="ocupado"></td>
                            <td><img src="img/ocupado.png" with="30" height="30" alt="ocupado"></td>
                            <td><img src="img/ocupado.png" with="30" height="30" alt="ocupado"></td>
                            <td><img src="img/ocupado.png" with="30" height="30" alt="ocupado"></td>
                            <td>... 
                                -->
            </div>

            <div class="container col-md-4">
                <form action="#" method="POST" enctype="multipart/form-data">
                    <p>
                    <h2>Mostrar Sala:</h2>
                    <p>Sala:
                        <select class="form-select" name="sala">
                            <?php
                            // Mostrar listado de Salas
                            foreach (salaEnum::cases() as $sala) {
                                echo "<option value='$sala->name'>".$sala->value."</option>";
                            }
                            ?>
                        </select>
                        <br>
                        <input type="submit" class="btn btn-primary" value="Mostrar Sala" name="mostrar">

                    <p>
                    <h2>Comprar, Reservar o Cancelar asiento:</h2>
                    <p>Asiento:</p>
                    <p>Fila: <input type="text"></p>
                    <p>Columna: <input type="text"></p>
                    <input type="submit" class="btn btn-success" value="Comprar" name="comprar">
                    <input type="submit" class="btn btn-warning" value="Reservar" name="reservar">
                    <input type="submit" class="btn btn-danger" value="Cancelar Reserva" name="cancelar">

                    <p>
                    <h2>Importar fichero sala:</h2>
                    <p>Seleccionar Sala:
                        <select class="form-select" name="salaImport">
                            <?php
                            // Mostrar listado de Salas
                            foreach (salaEnum::cases() as $sala) {
                                echo "<option value='$sala->name'>".$sala->value."</option>";
                            }
                            ?>
                        </select>
                        <br>
                        <input type="file" name="fsala">
                        <br>
                        <br>
                        <input type="submit" class="btn btn-info" value="Importar Sala" name="importar">
                </form>
            </div>
        </div>
</body>

</html>