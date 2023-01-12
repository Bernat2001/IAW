<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="estilos/style.css?v=0.0.1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>alquilar</title>
</head>
<body>
    <form method="post">
        <?php $primaria = $_GET['primaria']; echo "Alquilar la bicicleta con ID $primaria"; ?>
        <br><br>
        <label for="lang">Cliente</label>
        <select name="cli">
        <?php
    include "biblioteca.php";
    connection();
    $tabla = 'clientes';
    consulta_tabla($tabla);
    while ($row = mysqli_fetch_assoc($result)) {
      echo '<option value="' . $row['codigo_cli'] . '">' . $row['codigo_cli'] . ' - ' . $row['nombre_cli'] . '</option>';
    }
    ?>
        </select>
        <br> <br>
        <label for="start-date">Fecha de alquler:</label>
        <input type="date" value="2023-01-12" name="fecha" min="2023-01-12">
        <br><br>
        <input type='submit' name='Alquilar' value='Alquilar'>
        <input type="submit" name="Volver" value="Volver" formaction="mainpage.php" class="boton">
    </form>

    <?php
if (isset($_POST['Alquilar'])){
    $cli = intval($_POST['cli']); // Aqui estamos convirtiendo el valor a entero
    $fecha = date("Y-m-d H:i:s", strtotime($_POST['fecha'])); // Aqui estamos conviertiendo la fecha en un formato valido
    $conexion = mysqli_connect('localhost', 'root', '', 'CletAsir');
    try {
        if (!$conexion) {
            throw new Exception("Error al conectar a la base de datos.");
        }
        mysqli_autocommit($conexion, FALSE);
        $sql1= "UPDATE bicicletas SET disponible=0 WHERE codigo_bi = ?";
        $stmt1 = mysqli_prepare($conexion, $sql1);
        mysqli_stmt_bind_param($stmt1, 'i', $primaria);

        $sql2 = "INSERT INTO alquiler (codigo_cli,codigo_bi,Fech_Alquiler) VALUES (?,?,?) ";
        $stmt2 = mysqli_prepare($conexion, $sql2);
        mysqli_stmt_bind_param($stmt2, 'iis', $cli, $_GET['primaria'], $fecha);
        
        if (!mysqli_stmt_execute($stmt1) || !mysqli_stmt_execute($stmt2)) {
            throw new Exception("Error al actualizar el registro: " . mysqli_error($conexion));
        } else {
            mysqli_commit($conexion);
            echo '<div class="mensaje_ok">Alquiler realizado con éxito</div>';
            header('refresh:1;url=mainpage.php');
        }
    } catch (Exception $e) {
        mysqli_rollback($conexion);
        echo $e->getMessage();
    } finally {
        mysqli_close($conexion);
    }
}
?>

            
</body>
</html>