<?php

include("../../modelo/conexion_bd.php");
$con = $conexion;

$id = $_POST["id"];
$nombre = $_POST['nombre'];
$ape_paterno = $_POST['ape_paterno'];
$ape_materno = $_POST['ape_materno'];
$email = $_POST['email'];
$tipo = $_POST['tipo'];

$sql="UPDATE miembro SET nombre='$nombre', ape_paterno='$ape_paterno', ape_materno='$ape_materno', email= '$email', tipo='$tipo' WHERE id='$id'";
$query = mysqli_query($con, $sql);

if($query){
    Header("Location: ../../verCliente.php");
}else{

}

?>