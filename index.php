<html>
<link rel="stylesheet" href="estilos/estilo.css">

<body>

<?php

try{

$conexion = mysqli_connect('localhost', 'root', '', 'CletAsir');

} catch (mysqli_sql_exception $e) {

 $error = $e->getMessage();
 echo $error . "<br><br>";
 
 die('Error al conectar con el servidor: ' . mysqli_connect_error());
}

if (isset($_GET['primaria'])) {
    $primaria = $_GET['primaria'];
    $eliminar = "DELETE from equipo where nomequipo like ?";
    $stmt = mysqli_prepare($conexion, $eliminar);
    mysqli_stmt_bind_param($stmt, 's', $primaria);
    if (!mysqli_stmt_execute($stmt)) {
        die("No se ha podido realizar el borrado del equipo.".mysqli_error($conexion));
    }
    header("location:03_03.php");
}

$consultaSQL = "SELECT * FROM bicicletas";


try{
  $result = mysqli_query($conexion , $consultaSQL);
}
catch (mysqli_sql_exception $e) {

  echo 'No se ha podido realizar la consulta ' . mysqli_error($conexion);
  exit;
}

?>

<br>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
    <input type="submit" name="Nueva bicileta" value="Nueva bicileta">
    <input type="submit" name="Nuevo modelo" value="Nuevo modelo">
</form>
<br>


<?php

echo "<table border=17><tr><th colspan=7>Tabla bicis</tr></th><tr><th>ID</th><th>Modelo</th><th>Color</th><th>Incidencias</th><th>Disponibilidad</th><th></th><th></th></tr>";
while ($row = mysqli_fetch_array($result/*, MYSQLI_ASSOC*/)) {
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
echo "</table>";

mysqli_free_result($result);
mysqli_close($conexion)

?>

</body>
</html>