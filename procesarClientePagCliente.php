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

// Procesar el RUT antes de enviarlo
$rut_cliente_limpio = limpiarRut($_POST['rut_cliente']);

$obj = new ControladorCliente();
$obj->insertarCliente($rut_cliente_limpio, $_POST['nombre_cliente'], $_POST['apellido_cliente'], $_POST['email'], $_POST['telefono'], $_POST['direccion'], $_POST['parentesco'], $_POST['rol'], $_POST['id_comuna'], $_POST['clave']);
?>
