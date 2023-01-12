<?php

$conexion = mysqli_connect('localhost', 'root', '', 'CletAsir');
    $consultaSQL = "UPDATE bicicletas SET incidencias=?, disponible=? WHERE codigo_bi=?";
    $stmt = mysqli_prepare($conexion, $consultaSQL);
    $valor2 = $_GET['primaria'];

    $incidencia = 'sin incidencias';
    $primaria= filter_var($valor2, FILTER_SANITIZE_NUMBER_INT);
    $disponible = 1;

    mysqli_stmt_bind_param($stmt, 'sii', $incidencia, $disponible, $primaria);

    try {
        if (!mysqli_stmt_execute($stmt)) {
            throw new mysqli_sql_exception(mysqli_error($conn));
        }
        header('refresh:0;url=mainpage.php');
    } catch (mysqli_sql_exception $e) {
        echo "Error al dar de alta la bicicleta: " . $e->getMessage();
    }
    mysqli_stmt_close($stmt);


?>