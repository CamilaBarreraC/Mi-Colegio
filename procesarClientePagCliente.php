<?php
// ARCHIVO PROCESADOR PARA INSERTAR CLIENTES

require_once('controladorPagCliente/crud_cliente/controlador_cliente.php');

// Función para limpiar y transformar el RUT a números
function limpiarRut($rut) {
    // Quitar puntos y guion
    $rut = str_replace(['.', '-'], '', $rut);

    // Verificar si el último carácter es "k" o "K", para ingresarlo a la bd como valor int
    $ultimo_caracter = substr($rut, -1);
    if (strtolower($ultimo_caracter) == 'k') {
        // Remover el "K" y añadir "10"
        $rut = substr($rut, 0, -1) . '10';
    }

    return $rut;
}

// Función para validar el RUT chileno
function validarRut($rut) {
    // Asegurarse de que el RUT tenga solo números y una "K" o "k" como DV
    if (!preg_match('/^\d+([kK])?$/', $rut)) {
        return false;
    }

    $rut = str_replace(['.', '-'], '', $rut);
    $cuerpo = substr($rut, 0, -1);
    $dv = strtoupper(substr($rut, -1));

    $suma = 0;
    $factor = 2;
    for ($i = strlen($cuerpo) - 1; $i >= 0; $i--) {
        $suma += $factor * $cuerpo[$i];
        $factor = $factor == 7 ? 2 : $factor + 1;
    }
    $dv_calculado = 11 - ($suma % 11);
    if ($dv_calculado == 11) $dv_calculado = 0;
    if ($dv_calculado == 10) $dv_calculado = 'K';

    return $dv == $dv_calculado;
}

// Procesar el RUT antes de enviarlo
$rut_cliente = $_POST['rut_cliente'];

// Validar el RUT antes de la inserción
if (!validarRut($rut_cliente)) {
    header("Location: index.php?invalido=true");
    exit();
}

$rut_cliente_limpio = limpiarRut($rut_cliente);

$obj = new ControladorCliente();
$obj->insertarCliente($rut_cliente_limpio, $_POST['nombre_cliente'], $_POST['apellido_cliente'], $_POST['email'], $_POST['telefono'], $_POST['direccion'], $_POST['parentesco'], $_POST['rol'], $_POST['id_comuna'], $_POST['clave']);
?>
