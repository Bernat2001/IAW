<!DOCTYPE html>
<html>
<head>
  <title>Añadir un nuevo modelo</title>
  <link rel="stylesheet" href="estilos/style.css">
</head>
<body>
  <h1>Añadir un nuevo modelo</h1>

  <form action="nuevo_modelo.php" method="post">
    <label for="nombre_mo">Nombre:</label><br>
    <input type="text" name="nombre_mo"><br>

    <label for="descripcion">Descripción:</label><br>
    <textarea name="descripcion"></textarea><br>

    <label for="dimensiones">Dimensiones:</label><br>
    <input type="number" name="dimensiones" min="10"><br>

    <label for="año_compra">Año de compra:</label><br>
    <input type="number" name="año_compra" min="2023" value="2023"><br>

    <label for="imagen">Imagen:</label><br>
    <input type="text" name="imagen"><br>

    <input type="submit" name="Añadir_modelo" value="Añadir modelo" class="boton">
    <input type="submit" name="Volver" value="Volver" formaction="mainpage.php" class="boton">
  </form><br> 


  <?php
  include "biblioteca.php";
  connection();
  consulta();
  mostrar_modelos($result);
  cerrar_conexion();

  if (isset($_POST['Añadir_modelo'])) {
    $nombre_mo = $_POST['nombre_mo'];
    $descripcion = $_POST['descripcion'];
    $dimensiones = $_POST['dimensiones'];
    $año_compra = $_POST['año_compra'];
    $imagen = $_POST['imagen'];
    $stock = 0;

    connection();
    $consultaSQL = "SELECT * FROM modelos";
    try {
      $result = mysqli_query($conn , $consultaSQL);
    } catch (mysqli_sql_exception $e) {
      echo 'No se ha podido realizar la consulta ' . mysqli_error($conn);
      exit;
    }

    $sql = "INSERT INTO modelos (nombre_mo, descripcion, dimensiones, año_compra, imagen, stock)
    VALUES ('$nombre_mo', '$descripcion', '$dimensiones', '$año_compra', '$imagen', '$stock')";

  if ($conn->query($sql) === TRUE) {
  echo "Modelo añadido correctamente";
  } else {
  echo "Error: " . $sql . "<br>" . $conn->$e;
  }
      $conn->close();
  }
  ?>

</body>
</html>
