<?php
  function connection() {
    try {
        global $conn;
        global $error;
        $conn = mysqli_connect('localhost', 'root', '', 'CletAsir');
      } catch (mysqli_sql_exception $e) {
        $error = $e->getMessage();
        echo $error . "<br><br>";
        die('Error al conectar con el servidor: ' . mysqli_connect_error());
      }
  }
  function consulta() {
    global $conn;
    global $result;
    $consultaSQL = "SELECT * FROM bicicletas";
    try {
      $result = mysqli_query($conn , $consultaSQL);
    } catch (mysqli_sql_exception $e) {
      echo 'No se ha podido realizar la consulta ' . mysqli_error($conn);
      exit;
    }
  }

  function mostrar_tabla($result) {
    echo "<table border=17><tr><th colspan=7 id='tablabicis'>Tabla bicis</th></tr>
    <tr><th>ID</th><th>Modelo</th><th>Color</th><th>Incidencias</th><th>Disponibilidad</th><th></th><th></th></tr>";
    while ($row = mysqli_fetch_array($result)) {
        echo "<tr>";
        echo "<td>", $row['codigo_bi'], "</td>";
        echo "<td>", $row['codigo_mo'], "</td>";
        echo "<td>", $row['color'], "</td>";
        echo "<td>", $row['incidencias'], "</td>";
        if ($row['disponible'] == 1) {
          echo "<td>Sí</td>";
      } else {
          echo "<td>No</td>";
      }
        echo "<td>"."<a href='invent.php?primaria=".$row['codigo_mo']."'id='enlaces'>Alquilar</a></td>";
        echo "<td>"."<a href='invent.php?primaria=".$row['codigo_bi']."'id='enlaces'>Dar de baja</a></td>";
        echo "</tr>\n";
    }
    echo "</table><br>";
  }

  function cerrar_conexion() {
    global $result;
    global $conn;
    mysqli_free_result($result);
    mysqli_close($conn);
  }

function mostrar_modelos($result)
{
  global $conn;
  $consultaSQL = "SELECT * FROM modelos";
  try {
    $result = mysqli_query($conn, $consultaSQL);
  } catch (mysqli_sql_exception $e) {
    echo 'No se ha podido realizar la consulta ' . mysqli_error($conn);
    exit;
  }
  echo "<table border=17><tr><th colspan=7 id='tablabicis'>Tabla modelos</th></tr>
  <tr><th>ID</th><th>Modelo</th><th>Descripción</th><th>Dimensiones</th><th>Año de compra</th><th>Imagen</th><th>Stock</th></tr>";
  while ($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>", $row['codigo_mo'], "</td>";
    echo "<td>", $row['nombre_mo'], "</td>";
    echo "<td>", $row['descripcion'], "</td>";
    echo "<td>", $row['dimensiones'], "</td>";
    echo "<td>", $row['año_compra'], "</td>";
    echo "<td>", $row['imagen'], "</td>";
    echo "<td>", $row['stock'], "</td>";
  }
  echo "</table><br>";
}

?>
