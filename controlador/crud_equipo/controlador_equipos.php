<?php
if (!empty($_POST["registro"]) ){ #verifica que no esten vacios los campos del formulario
    if (empty($_POST["nombre"]) or empty( $_POST["tipo"]) or empty( $_POST["zona"]) or empty($_POST["fk_equipamiento"]) ) {
        echo "<script>alert('Debe rellenar todos los campos');</script>";
    } else {
        $nombre = $_POST["nombre"];
        $tipo = $_POST["tipo"];
        $ape_materno = $_POST["zona"];
        $fk_equipamiento = $_POST["fk_equipamiento"];

        $sql = $conexion->query("insert into equipamiento(fk_equipamiento, nombre, tipo, zona) values('$fk_equipamiento', '$nombre','$tipo','$zona')");
        if ($sql==1) {
            echo "<script>alert('Equipo registrado correctamente');</script>"; # si la consulta es correcta la base de datos arroja como respuesta un "1"
        } else {
            echo "<script>alert('Error al ingresar equipo');</script>"; #si la consulta esta incorrecta la base de datos arroja un "0"
        }
    }
}
?>