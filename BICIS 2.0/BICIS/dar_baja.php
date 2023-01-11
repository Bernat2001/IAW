<!DOCTYPE html>
<html>
<head>
  <title>Baja</title>
  <link rel="stylesheet" href="estilos/style.css?v=0.0.1">
</head>
    <body>
<?php
include "biblioteca.php";
    connection();
?>

<form method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
    <br><br><label>Incidencias: </label>
        <textarea name="incidencia"></textarea value="<?php if(!empty($_POST['incidencia'])){echo $_POST['incidencia'];}?>"><br>
    <?php if (isset($_POST['baja']) && empty($_POST['incidencia'])) echo "<span style='color:red'>Campo requerido</span><br>"?><br>
    <br>
    <input type="submit" name="baja" value="baja">
    <input type="submit" name="Volver" value="Volver" formaction="mainpage.php" class="boton">
</form>
<?php
if(isset($_POST['baja']) && !empty($_POST['incidencia']) && (isset($_GET['primaria']))){
$primaria = $_GET['primaria'];
$tabla = 'bicicletas';
$incidencia = filter_var($_POST['incidencia'],FILTER_SANITIZE_STRING);
$disponible=0;
consulta_tabla($tabla);
$consultaSQL = "UPDATE bicicletas SET incidencias=?, disponible=? WHERE codigo_bi=?";
$stmt = mysqli_prepare($conn, $consultaSQL);


mysqli_stmt_bind_param($stmt, 'sii', $incidencia, $disponible, $primaria);

    try {
        if (!mysqli_stmt_execute($stmt)) {
        throw new mysqli_sql_exception(mysqli_error($conn));
        }
        echo '<div class="mensaje_ok">Incidencia actualizada</div>';
    } catch (mysqli_sql_exception $e) {
        echo "Error al insertar la incidencia: " . $e->getMessage();
    }
    mysqli_stmt_close($stmt);
}

?>

    </body>
</html>