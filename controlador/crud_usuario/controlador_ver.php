<?php
    session_start();

    $usu = $_SESSION['usuario'];

    $query = $conexion->query("SELECT clases.id, clases.nombre, horario, capacidad, fk_clases FROM clases JOIN profesional ON profesional.fk_profesional = clases.fk_clases where profesional.fk_profesional = '$usu'; ");

    $retorno = [];

    $i = 0;
    while($fila = $query->fetch_assoc()){
        $retorno[$i] = $fila;
        $i++;
    }
    
    $usuarios = $conexion->$retorno;

?>