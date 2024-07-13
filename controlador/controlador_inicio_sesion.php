<?php
require 'modelo/conexion_bd.php';
session_start();

// Función para limpiar y transformar el RUT a números para insertar en bd
function limpiarRut($rut) {
    $rut = str_replace(['.', '-'], '', $rut);
    $ultimo_caracter = substr($rut, -1);
    if (strtolower($ultimo_caracter) == 'k') {
        $rut = substr($rut, 0, -1) . '10';
    }
    return $rut;
}

// Función para validar el RUT chileno
function validarRut($rut) {
    // Limpiar el RUT y verificar que solo contenga dígitos y una letra K al final
    $rut = str_replace(['.', '-'], '', $rut);
    if (!preg_match('/^\d+(\d|k|K)$/', $rut)) {
        return false; // RUT no válido si no cumple con el formato
    }

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

if (!empty($_POST["btniniciar"])) {
    if (empty($_POST["rut_cliente"]) || empty($_POST["clave"])) {
        ?>
        <script>         
            Swal.fire({
            icon: "error",
            title: "<h3 style='font-family: Barlow; font-style: italic'>Intente nuevamente</h3>",
            text: "Ingrese las credenciales"
            });
        </script>
        <?php    
    } else {
        $rut_cliente = limpiarRut($_POST["rut_cliente"]);
        $clave = $_POST["clave"];

        if (!validarRut($rut_cliente)) {
            header("Location: index.php?invalido=true");
            exit();
        }

        $sql = "SELECT * FROM cliente 
                JOIN comuna ON cliente.id_comuna = comuna.id_comuna
                JOIN region ON comuna.id_region = region.id_region
                WHERE rut_cliente='$rut_cliente' AND clave='$clave'";

        $result = $conexion->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $_SESSION['rut_cliente'] = $row['rut_cliente'];
            $_SESSION['nombre_cliente'] = $row['nombre_cliente'];
            $_SESSION['apellido_cliente'] = $row['apellido_cliente'];
            $_SESSION['clave'] = $row['clave'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['telefono'] = $row['telefono'];
            $_SESSION['direccion'] = $row['direccion'];
            $_SESSION['parentesco'] = $row['parentesco'];
            $_SESSION['id_comuna'] = $row['id_comuna'];
            $_SESSION['nombre_comuna'] = $row['nombre_comuna'];
            $_SESSION['nombre_region'] = $row['nombre_region'];
            $_SESSION['rol'] = $row['rol'];
            
            ?>
            <script>           
                Swal.fire({
                title: "Datos correctos",
                text: "Ingresando...",
                icon: "success"
                });
            </script>     
            <?php 
            if ($_SESSION['rol'] == "Administrador") {
                header("Location: Administracion.php");  
            } else if ($_SESSION['rol'] == "Cliente") {
                header("Location: PagCliente.php");  
            }               
        } else {          
            ?>
            <script>         
                Swal.fire({
                icon: "error",
                title: "<h3 style='font-family: Barlow; font-style: italic'>Intente nuevamente</h3>",
                text: "Datos incorrectos"
                });
            </script>
            <?php         
        }
    }
}
?>
