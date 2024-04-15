<?php

if (!empty($_POST["registro"]) ){ #verifica que no esten vacios los campos del formulario
    if (empty($_POST["fecha"])) {
        echo "<script>alert('Debe rellenar todos los campos');</script>";
    } else {
        $fecha = $_POST["fecha"];
        $fkAsist = $_POST['fk'];
        $asist = $_POST['asist'];
        $email = $_POST['email'];
        $asunto = "Asistencia";
        $mensaje = "Asistencia de la clase de hoy, fecha: $fecha. Ha quedado $asist";
        $header = "From: noreply@example.com" . "\r\n";
        $header.= "Reply-To: reply@example.com" . "\r\n";
        $header.= "X-Mailer: PHP/". phpversion();
        // función mail para enviar correo con asistencia
        $mail = @mail($email, $asunto, $mensaje);

        $sql = $conexion->query("insert into asistencia(fk_asistencia, presente, dia) values('$fkAsist','$asist','$fecha')");

        if ($sql==1) {
            echo "<script>alert('Asistencia registrada correctamente');</script>"; # si la consulta es correcta la base de datos arroja como respuesta un "1"
            if ($mail){
                echo "mail enviado";
            }
        } else {
            echo "<script>alert('Error al ingresar datos');</script>"; #si la consulta esta incorrecta la base de datos arroja un "0"
        }
    }
}
?>