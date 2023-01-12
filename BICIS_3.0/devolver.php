<?php
include "biblioteca.php";
$primaria = $_GET['primaria'];
connection();
  $sql1= "UPDATE bicicletas SET disponible=1 WHERE codigo_bi = ?";
        $stmt1 = mysqli_prepare($conn, $sql1);
        mysqli_stmt_bind_param($stmt1, 'i', $primaria);
        mysqli_stmt_execute($stmt1);
        header('refresh:0;url=mainpage.php');


?>