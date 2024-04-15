<?php

include("../modelo/conexion_bd.php");
$con = $conexion;

$id=$_GET["id"];

$sql="DELETE FROM miembro WHERE id='$id'";
$query = mysqli_query($con, $sql);

if ($sql==1) {
    echo "<script>alert('Cliente eliminado correctamente');</script>"; # si la consulta es correcta la base de datos arroja como respuesta un "1"
    Header("Location: ../../verCliente.php");
} else {
    echo "<script>alert('Error al eliminar');</script>"; #si la consulta esta incorrecta la base de datos arroja un "0"
    Header("Location: ../../verCliente.php");
}


?>