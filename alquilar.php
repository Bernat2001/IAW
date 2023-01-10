<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>alquilar</title>
</head>
<body>
    <form method="post">
        <?php echo "Desea Alquilar o devolver la bicicleta con id " .$_GET['primaria']; ?>
        <br><br>
        <label for="lang">Cliente</label>
        <select name="cli">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        </select>
        <br> <br>
        <label for="start-date">Fecha de alquler:</label>
        <input type="date" value="2023-01-12" name="fecha" min="2023-01-12">
        <br><br>
        <input type='submit' name='Alquilar' value='Alquilar'>
        <input type='submit' name='Devolver' value='Devolver'>
        <a href="index.php"><input type='button' name='volver' value='Pagina Principal'></a>
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
        $sql1= "UPDATE bicicletas SET disponible=0 WHERE codigo_bi = ? AND disponible = 1";
        $stmt1 = mysqli_prepare($conexion, $sql1);
        mysqli_stmt_bind_param($stmt1, 'i', $cli);

        $sql2 = "INSERT INTO alquiler (codigo_cli,codigo_bi,Fech_Alquiler) VALUES (?,?,?) ";
        $stmt2 = mysqli_prepare($conexion, $sql2);
        mysqli_stmt_bind_param($stmt2, 'iis', $cli, $_GET['primaria'], $fecha);
        
        if (!mysqli_stmt_execute($stmt1) || !mysqli_stmt_execute($stmt2)) {
            throw new Exception("Error al actualizar el registro: " . mysqli_error($conexion));
        } else {
            mysqli_commit($conexion);
            echo "Bicicleta alquilada correctamente.";
        }
    } catch (Exception $e) {
        mysqli_rollback($conexion);
        echo $e->getMessage();
    } finally {
        mysqli_close($conexion);
    }
}






    if (isset($_POST['Devolver'])){
        $conexion = mysqli_connect('localhost', 'root', '', 'CletAsir');
        try {
            $sql= "UPDATE bicicletas set disponible=1 where codigo_bi = ?";
            $stmt = mysqli_prepare($conexion, $sql);
            mysqli_stmt_bind_param($stmt, 's', $_GET['primaria']);

            if (!mysqli_stmt_execute($stmt)) {
                echo "Error al actualizar el registro: " . mysqli_error($conexion);
            }
        }catch (Exception $e)  {
            echo $e->getMessage();
        }finally {
            mysqli_close($conexion);
        }
    }
?>

            
</body>
</html>
