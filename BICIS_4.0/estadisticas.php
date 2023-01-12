<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos/style.css?v=0.0.1">
    <title>Estadisticas</title>
</head>
<body>
<div class="table-container">
    <?php
        $conexion = mysqli_connect('localhost', 'root', '', 'CletAsir');

        // consultas
        $sql = "SELECT clientes.codigo_cli, nombre_cli, COUNT(*) as total_alquileres FROM clientes JOIN alquiler ON clientes.codigo_cli = alquiler.codigo_cli GROUP BY codigo_cli ORDER BY total_alquileres DESC";
        //$sql2= "SELECT codigo_bi, COUNT(*) as total_lloguers FROM alquiler GROUP BY codigo_bi ORDER BY total_lloguers DESC";
        $sql2 = "SELECT modelos.codigo_mo, modelos.nombre_mo, COUNT(*) as total_alquileres FROM alquiler 
        JOIN bicicletas ON alquiler.codigo_bi = bicicletas.codigo_bi 
        JOIN modelos ON bicicletas.codigo_mo = modelos.codigo_mo 
        GROUP BY modelos.codigo_mo 
        ORDER BY total_alquileres DESC";





        $sql3= "SELECT MONTH(Fech_Alquiler) as mes, COUNT(*) as total_lloguers FROM alquiler GROUP BY mes ORDER BY mes";

        $resultado = mysqli_query($conexion, $sql);
        $resultado2= mysqli_query($conexion, $sql2);
        $resultado3= mysqli_query($conexion, $sql3);
    ?>
    <table class="horizontal">
        <caption class='statics'>Total de alquileres por cliente</caption>
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Total de alquileres</th>
            </tr>
        </thead>
        <tbody>
    <?php
        while ($fila = mysqli_fetch_assoc($resultado)) {
            echo "<tr><td>" . $fila['codigo_cli'] . " - " . $fila['nombre_cli'] . "</td><td>" . $fila['total_alquileres'] . "</td></tr>";
        }
    ?>
</tbody>

    </table>
    <table class="horizontal">
    <caption class='statics'>Total de alquileres por modelo</caption>
        <thead>
            <tr>
                <th>Bicicleta</th>
                <th>Total de alquileres</th>
            </tr>
        </thead>
        <tbody>
        <?php
            while ($fila = mysqli_fetch_assoc($resultado2)) {
                echo "<tr><td>" . $fila['codigo_mo']. " - " . $fila['nombre_mo'] . "</td><td>" . $fila['total_alquileres'] . "</td></tr>";
            }
        ?>
    </tbody>


    </table>
    <table class="horizontal">
    <caption class='statics'>Total de alquileres realizados durante cada mes</caption>
        <thead>
            <tr>
                <th>Mes de alquiler</th>
                <th>Total de alquileres</th>
            </tr>
        </thead>
        <tbody>
            <?php
                while ($fila = mysqli_fetch_assoc($resultado3)) {
                    echo "<tr><td>" . $fila['mes'] . "</td><td>" . $fila['total_lloguers'] . "</td></tr>";
                }
                mysqli_close($conexion);
            ?>
        </tbody>
    </table>
</div>
<a href="mainpage.php" class="boton">Volver</a>
</body>
</html>
