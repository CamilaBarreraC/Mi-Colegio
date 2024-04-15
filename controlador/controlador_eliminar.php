<?php

include("../modelo/conexion_bd.php");
$con = $conexion;

$id=$_GET["id"];

$sql="DELETE FROM usuario WHERE id='$id'";
$query = mysqli_query($con, $sql);

if ($sql==1) {
    echo "<script>alert('Usuario eliminado correctamente');</script>"; # si la consulta es correcta la base de datos arroja como respuesta un "1"
    Header("Location: ../verUsuarios.php");
} else {
    echo "<script>alert('Error al eliminar');</script>"; #si la consulta esta incorrecta la base de datos arroja un "0"
    Header("Location: ../verUsuarios.php");
}


?>