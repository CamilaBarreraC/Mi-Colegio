<?php
if (!empty($_POST["registro"]) ){ #verifica que no esten vacios los campos del formulario
    if (empty($_POST["nombre"]) or empty( $_POST["ape_paterno"]) or empty( $_POST["ape_materno"]) or empty($_POST["usuario"]) or empty($_POST["clave"])) {
        echo "<script>alert('Debe rellenar todos los campos');</script>";
    } else {
        $nombre = $_POST["nombre"];
        $ape_paterno = $_POST["ape_paterno"];
        $ape_materno = $_POST["ape_materno"];
        $usuario = $_POST["usuario"];
        $rut = $_POST["rut"];
        $clave = $_POST["clave"];
        $sql = $conexion->query("insert into usuario(nombre, ape_paterno, ape_materno, usuario, rut, clave) values('$nombre','$ape_paterno','$ape_materno','$usuario', '$rut', '$clave')");
        if ($sql==1) {
            echo "<script>alert('Usuario registrado correctamente');</script>"; # si la consulta es correcta la base de datos arroja como respuesta un "1"
        } else {
            echo "<script>alert('Error al ingresar datos');</script>"; #si la consulta esta incorrecta la base de datos arroja un "0"
        }
    }
}
?>