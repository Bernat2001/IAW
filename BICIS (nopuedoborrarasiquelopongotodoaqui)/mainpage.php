<!DOCTYPE html>
<html>
<head>
  <title>Página Principal</title>
  <link rel="stylesheet" href="estilos/style.css">
</head>
<body>
    <div id="contenido"><br>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']?>" id="mainform">
        <input type="submit" name="Nueva bicicleta" value="Nueva bicicleta" formaction="nueva_bicicleta.php" class="boton">
        <input type="submit" name="Nuevo modelo" value="Nuevo modelo" formaction="nuevo_modelo.php" class="boton">
        <input type="submit" name="Estadísticas" value="Estadísticas" formaction="estadisticas.php" class="boton">
        </form><br>
    </div>

    <?php
        include "biblioteca.php";
        connection();
        consulta();
        mostrar_tabla($result);
        cerrar_conexion();
    ?>

</body>
</html>
