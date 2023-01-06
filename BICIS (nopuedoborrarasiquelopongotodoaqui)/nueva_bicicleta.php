<!DOCTYPE html>
<html>
<head>
  <title>Nueva Bicicleta</title>
  <link rel="stylesheet" href="estilos/style.css">
  <script src="biblioteca.php"></script>
</head>
<body>
<h1>Nueva Bicicleta</h1>
  <form action="insertar_bicicleta.php" method="post">
    <label for="codigo_mo">Código modelo:</label><br>
    <input type="text" id="codigo_mo" name="codigo_mo"><br>
    <label for="color">Color:</label><br>
    <input type="text" id="color" name="color"><br>
    <label for="incidencias">Incidencias:</label><br>
    <input type="text" id="incidencias" name="incidencias"><br><br>
    <input type="submit" value="Añadir bicicleta" class="boton">
    <input type="submit" name="Volver" value="Volver" formaction="mainpage.php" class="boton">
  </form>

  <?php
    include "biblioteca.php";

    if (isset($_POST['Añadir bicicleta']) && !empty($_POST['codigo_mo']) && !empty($_POST['color']) && !empty($_POST['incidencias'])) {
      $codigo_mo = $_POST['codigo_mo'];
      $color = $_POST['color'];
      $incidencias = $_POST['incidencias'];

      connection();

      $sql = "INSERT INTO bicicletas (codigo_mo, color, incidencias) VALUES ('$codigo_mo', '$color', '$incidencias')";
      if (mysqli_query($conn, $sql)) {
        echo "Nueva bicicleta añadida correctamente";
      } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }

      cerrar_conexion();
    } elseif(isset($_POST['submit'])) {
      echo "Debes completar todos los campos del formulario.";
    }
  ?>
</body>
</html>