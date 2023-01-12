<!DOCTYPE html>
<html>
<head>
  <title>Baja</title>
  <link rel="stylesheet" href="estilos/style.css?v=0.0.1">
</head>
<body>



<form method="post">
<?php echo "Bicicleta " .$_GET['primaria']; ?>
<br><br><label for="incidencia">Incidencia:</label><br>
    <input type="text" name="incidencia" value="<?php if(!empty($_POST['incidencia'])){echo $_POST['incidencia'];}?>"><br>
    <?php if (isset($_POST['baja']) && empty($_POST['incidencia'])) echo "<span style='color:red'>Campo requerido</span><br>"?><br>
    <br>
    <input type="submit" name="baja" value="Dar de baja">
    <input type="submit" name="Volver" value="Volver" formaction="mainpage.php" class="boton">
</form>
<?php

if(isset($_POST['baja']) && !empty($_POST['incidencia'])){
    
    $conexion = mysqli_connect('localhost', 'root', '', 'CletAsir');
    $consultaSQL = "UPDATE bicicletas SET incidencias=?, disponible=? WHERE codigo_bi=?";
    $stmt = mysqli_prepare($conexion, $consultaSQL);
    
    $valor1 = $_POST['incidencia'];
    $valor2 = $_GET['primaria'];

    $incidencia = filter_var($valor1, FILTER_SANITIZE_STRING);
    $primaria= filter_var($valor2, FILTER_SANITIZE_NUMBER_INT);
    $disponible = 0;

    mysqli_stmt_bind_param($stmt, 'sii', $incidencia, $disponible, $primaria);

    try {
        if (!mysqli_stmt_execute($stmt)) {
            throw new mysqli_sql_exception(mysqli_error($conn));
        }
        echo '<div class="mensaje_ok">Bicicleta dada de baja</div>';
    } catch (mysqli_sql_exception $e) {
        echo "Error al dar de baja la bicicleta: " . $e->getMessage();
    }
    mysqli_stmt_close($stmt);
}
?>

</body>
</html>