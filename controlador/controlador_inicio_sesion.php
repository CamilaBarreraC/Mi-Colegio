<?php
require 'modelo/conexion_bd.php';
session_start();

// Función para limpiar y transformar el RUT a números para insertar en bd
function limpiarRut($rut) {
    return str_replace(['.', '-'], '', $rut);
}

// Función para validar que el RUT tenga 12 caracteres y no contenga letras excepto la K
function validarRutFormato($rut) {
    return (strlen($rut) == 12 && preg_match('/^[0-9]{1,3}\.[0-9]{3}\.[0-9]{3}-[0-9kK]{1}$/', $rut));
}

// Función para validar el dígito verificador del RUT
function validarRut($rut) {
    $rut = limpiarRut($rut);
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
        $rut_cliente = $_POST["rut_cliente"];
        $clave = $_POST["clave"];

        // Validar formato y existencia del RUT
        if (!validarRutFormato($rut_cliente) || !validarRut($rut_cliente)) {
            header("Location: index.php?invalido=true");
            exit();
        }

        $rut_cliente_limpio = limpiarRut($rut_cliente);

        $sql = "SELECT * FROM cliente 
                JOIN comuna ON cliente.id_comuna = comuna.id_comuna
                JOIN region ON comuna.id_region = region.id_region
                WHERE rut_cliente='$rut_cliente_limpio' AND clave='$clave'";

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
                }).then(function() {
                    window.location.href = "<?php echo $_SESSION['rol'] == 'Administrador' ? 'Administracion.php' : 'PagCliente.php'; ?>";
                });
            </script>     
            <?php 
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
