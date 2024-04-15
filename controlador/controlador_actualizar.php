<?php

include("../modelo/conexion_bd.php");
$con = $conexion;

$id = $_POST["id"];
$nombre = $_POST['nombre'];
$ape_paterno = $_POST['ape_paterno'];
$ape_materno = $_POST['ape_materno'];
$usuario = $_POST['usuario'];
$rut = $_POST['rut'];

$sql="UPDATE usuario SET nombre='$nombre', ape_paterno='$ape_paterno', ape_materno='$ape_materno', usuario= '$usuario', rut='$rut' WHERE id='$id'";
$query = mysqli_query($con, $sql);

if($query){
    Header("Location: ../verUsuarios.php");
}else{

}

?>