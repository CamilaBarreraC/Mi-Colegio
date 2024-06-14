<?php

$mysqli = new mysqli('localhost', 'root', 'ipchile', 'mi_colegio');

if ($mysqli->connect_error) {
    echo 'Error de Conexión ' . $mysqli->connect_error;
    exit;
}
