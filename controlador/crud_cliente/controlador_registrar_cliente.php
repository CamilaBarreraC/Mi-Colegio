<?php
if (!empty($_POST["registro"]) ){ #verifica que no esten vacios los campos del formulario
    if (empty($_POST["nombre"]) or empty( $_POST["ape_paterno"]) or empty( $_POST["ape_materno"]) or empty($_POST["email"]) or empty($_POST["tipo"])) {
        echo "<script>alert('Debe rellenar todos los campos');</script>";
    } else {
        $nombre = $_POST["nombre"];
        $ape_paterno = $_POST["ape_paterno"];
        $ape_materno = $_POST["ape_materno"];
        $email = $_POST["email"];
        $tipo = $_POST["tipo"];
        $sql = $conexion->query("insert into miembro(nombre, ape_paterno, ape_materno, email, tipo) values('$nombre','$ape_paterno','$ape_materno','$email', '$tipo')");
        if ($sql==1) {
            echo "<script>alert('Cliente registrado correctamente');</script>"; # si la consulta es correcta la base de datos arroja como respuesta un "1"
        } else {
            echo "<script>alert('Error al ingresar datos');</script>"; #si la consulta esta incorrecta la base de datos arroja un "0"
        }
    }
}
?>