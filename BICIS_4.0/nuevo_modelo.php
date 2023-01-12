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
    <input type="text" name="nombre_mo" value="<?php if(!empty($_POST['nombre_mo'])){echo $_POST['nombre_mo'];}?>"><br>
    <?php if (isset($_POST['Añadir_modelo']) && empty($_POST['nombre_mo'])) echo "<span style='color:red'>Campo requerido</span><br>"?><br>

    <label for="descripcion">Descripción:</label><br>
    <input type="text" name="descripcion" value="<?php if(!empty($_POST['descripcion'])){echo $_POST['descripcion'];}?>"><br>
    <?php if (isset($_POST['Añadir_modelo']) && empty($_POST['descripcion'])) echo "<span style='color:red'>Campo requerido</span><br>"?><br>

    <label for="dimensiones">Dimensiones:</label><br>
    <input type="number" name="dimensiones" min="10" max="30" value="<?php if(!empty($_POST['dimensiones'])){echo $_POST['dimensiones'];}?>"><br>
    <?php if (isset($_POST['Añadir_modelo']) && empty($_POST['dimensiones'])) echo "<span style='color:red'>Campo requerido</span><br>"?><br>

    <label for="año_compra">Año de compra:</label><br>
  <input type="number" name="año_compra" min="2023" value="<?php if(!empty($_POST['año_compra'])){echo $_POST['año_compra'];} else {echo '2023';}?>"><br>
  <?php if (isset($_POST['Añadir_modelo']) && empty($_POST['año_compra'])) echo "<span style='color:red'>Campo requerido</span><br>"?><br>


    <label for="imagen">Imagen:</label><br>
    <input type="text" name="imagen" value="<?php if(!empty($_POST['imagen'])){echo $_POST['imagen'];}?>"><br>
    <?php if (isset($_POST['Añadir_modelo']) && empty($_POST['imagen'])) echo "<span style='color:red'>Campo requerido</span><br>"?><br>

    <input type="submit" name="Añadir_modelo" value="Añadir modelo" class="boton">
    <input type="submit" name="Volver" value="Volver" formaction="mainpage.php" class="boton">
  </form><br> 



  <?php
  /* Incluir biblioteca y establecer conexión a la base de datos */
  include "biblioteca.php";

  connection();

  /* Realizar consulta y mostrar resultados */
  consulta();
  

  /* Verificar si se ha recibido el formulario y si todos los campos han sido completados */
    if (isset($_POST['Añadir_modelo']) && !empty($_POST['nombre_mo']) && !empty($_POST['descripcion']) && !empty($_POST['dimensiones']) && !empty($_POST['año_compra'] && !empty($_POST['imagen']))) {
      /* Asignar valores a variables a partir de los datos recibidos por el formulario */
      $nombre_mo = $_POST['nombre_mo'];
      $descripcion = $_POST['descripcion'];
      $dimensiones = $_POST['dimensiones'];
      $año_compra = $_POST['año_compra'];
      $imagen = $_POST['imagen'];
      $stock = 0;

      /* Realizar consulta a la tabla modelos */
      connection();
      $SQL = "SELECT nombre_mo FROM modelos WHERE nombre_mo = ?";
      $stmt = mysqli_prepare($conn, $SQL);
      mysqli_stmt_bind_param($stmt, 's', $nombre_mo);
      $nombre_mo = $_POST['nombre_mo'];
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);

      if (mysqli_num_rows($result) > 0) {
        echo '<div class="mensaje_error">El nombre del modelo ya existe</div>';
        header('refresh:2;url=nuevo_modelo.php');
      } else {
        /* Continuar con el resto del código para insertar el nuevo modelo */
        $SQL = "INSERT INTO modelos (nombre_mo, descripcion, dimensiones, año_compra, imagen, stock) VALUES (?,?,?,?,?,?)";
        $stmt = mysqli_prepare($conn, $SQL);
        /* Filtrar y sanitizar los datos recibidos por el formulario */

        $nombre_mo = filter_var($_POST['nombre_mo'], FILTER_SANITIZE_STRING);
        $descripcion = filter_var($_POST['descripcion'], FILTER_SANITIZE_STRING);
        $dimensiones = filter_var($_POST['dimensiones'], FILTER_SANITIZE_NUMBER_INT);
        $año_compra = filter_var($_POST['año_compra'], FILTER_SANITIZE_NUMBER_INT);
        $imagen = filter_var($_POST['imagen'], FILTER_SANITIZE_STRING);
        /* Vincular variables a la consulta preparada */
        mysqli_stmt_bind_param($stmt, 'ssiisi', $nombre_mo, $descripcion, $dimensiones, $año_compra, $imagen, $stock);
        /* Asignar valores a las variables vinculadas */
        $nombre_mo = $_POST['nombre_mo'];
        $descripcion = $_POST['descripcion'];
        $dimensiones = $_POST['dimensiones'];
        $año_compra = $_POST['año_compra'];
        $imagen = $_POST['imagen'];
        $stock = 0;

        /* Ejecutar consulta */
        try {
          if (!mysqli_stmt_execute($stmt)) {
            throw new mysqli_sql_exception(mysqli_error($conn));
          }
          echo '<div class="mensaje_ok">Modelo añadido correctamente</div>';
        } catch (mysqli_sql_exception $e) {
          /* Mostrar mensaje de error en caso de fallo en la consulta */
          echo "Error al insertar el modelo: " . $e->getMessage();
        }
        header('refresh:2;url=nuevo_modelo.php');

        /* Cerrar consulta preparada */
        mysqli_stmt_close($stmt);


      }
    }
  mostrar_modelos($result);

  /* Cerrar conexión a la base de datos */
  mysqli_close($conn);
  ?>

</body>
</html>