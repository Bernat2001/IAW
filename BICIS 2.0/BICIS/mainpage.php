<!DOCTYPE html>
<html>
<head>
  <title>Página Principal</title>
  <link rel="stylesheet" href="estilos/style.css?v=0.0.1">
</head>
<body>
    <div id="contenido"><br>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']?>" id="mainform">
        <input type="submit" name="Nuevo modelo" value="Nuevo modelo" formaction="nuevo_modelo.php" class="boton">
        <input type="submit" name="Nueva bicicleta" value="Nueva bicicleta" formaction="nueva_bicicleta.php" class="boton">
        <input type="submit" name="Estadísticas" value="Estadísticas" formaction="estadisticas.php" class="boton">
        </form><br>
    </div>

    <?php
        include "biblioteca.php";
        connection();
            $consultaSQL = "SELECT bicicletas.*, modelos.nombre_mo FROM bicicletas INNER JOIN modelos ON bicicletas.codigo_mo = modelos.codigo_mo order by codigo_bi";
            try {
              $result = mysqli_query($conn , $consultaSQL);
            } catch (mysqli_sql_exception $e) {
              echo 'No se ha podido realizar la consulta ' . mysqli_error($conn);
              exit;
            }


        mostrar_tabla($result);
        cerrar_conexion();
    ?>

</body>
</html>
