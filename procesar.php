<!-- ESTE ARCHIVO PROCESA LOS DATOS DEL MODELO CLIENTE EN MVC -->

<?php
if (isset($_POST['rut_cliente'])) {
    $rut = $_POST['rut_cliente'];

    // Elimina puntos y guión del RUT
    $rut = preg_replace('/[.-]/', '', $rut);

    // Validar el RUT
    if (isValidRut($rut)) {
        // Si el RUT es válido, realizar la inserción en la base de datos
        require_once ('controlador/crud_cliente/controlador_cliente.php');

        $nombre_cliente = $_POST['nombre_cliente'];
        $apellido_cliente = $_POST['apellido_cliente'];
        $email = $_POST['email'];
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];
        $parentesco = $_POST['parentesco'];
        $rol = $_POST['rol'];
        $id_comuna = $_POST['id_comuna'];
        $clave = $_POST['clave'];

        $obj = new ControladorCliente();
        $obj->insertarCliente($rut, $nombre_cliente, $apellido_cliente, $email, $telefono, $direccion, $parentesco, $rol, $id_comuna, $clave);
        exit;
    } else {
        // Si el RUT no es válido, redirigir de vuelta a usuario.php con estado=invalido
        header("Location: Usuarios.php?estado=invalido");
        exit;
    }
}

// Función para validar el RUT
function isValidRut($rut) {
    $rut = preg_replace('/[^0-9kK]/', '', $rut);
    if (empty($rut)) {
        return false;
    }

    $dv = substr($rut, -1);
    $numero = substr($rut, 0, -1);

    $suma = 0;
    $multiplo = 2;

    for ($i = strlen($numero) - 1; $i >= 0; $i--) {
        $suma += $numero[$i] * $multiplo;
        $multiplo = ($multiplo == 7) ? 2 : $multiplo + 1;
    }

    $dvr = 11 - ($suma % 11);

    if ($dvr == 11) {
        $dvr = 0;
    }

    if ($dvr == 10) {
        $dvr = 'K';
    }

    return strtoupper($dv) == $dvr;
}
?>
