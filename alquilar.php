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
        <input type='submit' name='Alquilar' value='Alquilar'>
        <input type='submit' name='Devolver' value='Devolver'>
        <a href="index.php"><input type='button' name='volver' value='Pagina Principal'></a>
    </form>

    <?php
        if (isset($_POST['Alquilar'])){
            $conexion = mysqli_connect('localhost', 'root', '', 'CletAsir');
            $sql= "UPDATE bicicletas set disponible=0 where codigo_bi = ?";
            $stmt = mysqli_prepare($conexion, $sql);
            mysqli_stmt_bind_param($stmt, 's', $_GET['primaria']);

            if (!mysqli_stmt_execute($stmt)) {
                echo "Error al actualizar el registro: " . mysqli_error($conexion);
            } 
            mysqli_close($conexion);
            }

            if (isset($_POST['Devolver'])){
                $conexion = mysqli_connect('localhost', 'root', '', 'CletAsir');
                $sql= "UPDATE bicicletas set disponible=1 where codigo_bi = ?";
                $stmt = mysqli_prepare($conexion, $sql);
                mysqli_stmt_bind_param($stmt, 's', $_GET['primaria']);
    
                if (!mysqli_stmt_execute($stmt)) {
                    echo "Error al actualizar el registro: " . mysqli_error($conexion);
                } 
                mysqli_close($conexion);
                }


        ?>


            
</body>
</html>
