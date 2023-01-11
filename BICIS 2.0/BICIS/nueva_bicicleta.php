<!DOCTYPE html>
<html>
<head>
  <title>Añadir una nueva bicicleta</title>
  <link rel="stylesheet" href="estilos/style.css?v=0.0.1">
</head>
<body>
  <h1>Añadir una nueva bicicleta</h1>
  <form action="nueva_bicicleta.php" method="post">
  <label for="modelo">Modelo:</label><br>
  <select name="modelo" id="modelo">
    <?php
    include "biblioteca.php";
    connection();
    $tabla = 'modelos';
    consulta_tabla($tabla);
    while ($row = mysqli_fetch_assoc($result)) {
      echo '<option value="' . $row['codigo_mo'] . '">' . $row['codigo_mo'] . ' - ' . $row['nombre_mo'] . '</option>';
    }
    ?>
    
    </select><br><br>

<label for="color">Color:</label><br>
<input type="text" name="color" value="<?php if(!empty($_POST['color'])){echo $_POST['color'];}?>"><br>
<?php if (isset($_POST['Añadir_bicicleta']) && empty($_POST['color'])) echo "<span style='color:red'>Campo requerido</span><br>"?><br>

  <input type="submit" name="Añadir_bicicleta" value="Añadir bicicleta" class="boton">
  <input type="submit" name="Volver" value="Volver" formaction="mainpage.php" class="boton">
    </form><br>

    <?php
if (isset($_POST['Añadir_bicicleta']) && !empty($_POST['color'])) {

  $modelo_anyadido = intval($_POST['modelo']);
  $color = $_POST['color'];
  $color = strtolower($color);
  $color = ucfirst($color); // Convertir primera letra en mayúscula y el resto en minúsculas
  
// ROLLBACK

$todo_bien = true;
mysqli_autocommit($conn, FALSE);

$consultaSQL = "INSERT INTO bicicletas (codigo_mo, color, incidencias, disponible) VALUES ($modelo_anyadido, '$color', 'sin incidencias', 1)";
if (mysqli_query($conn, $consultaSQL) != true) $todo_bien = false;

$consultaSQL = "UPDATE modelos SET stock=stock+1 WHERE codigo_mo='$modelo_anyadido'";
if (mysqli_query($conn, $consultaSQL) != true) $todo_bien = false;

if ($todo_bien == true) {
    mysqli_commit($conn);
    print '<div class="mensaje_ok">Bicicleta añadida correctamente</div>';
    mysqli_close($conn);
    header('refresh:1;url=nueva_bicicleta.php');
}else {
    mysqli_rollback($conn);
    print "<p>No se han podido realizar los cambios.</p>";
    mysqli_close($conn);
}
}

?>

</body>
</html>