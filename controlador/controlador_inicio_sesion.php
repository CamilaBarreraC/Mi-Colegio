<?php
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
require 'modelo/conexion_bd.php';
session_start();

if ( !empty($_POST["btniniciar"]) ){ #verifica que no esten vacios los campos del formulario
    if (empty($_POST["rut_cliente"]) or empty( $_POST["clave"])) {
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

        $sql = "select * from cliente where rut_cliente='$rut_cliente' and clave='$clave'";

        $result = $conexion->query($sql);   

        // Verifica el usuario
        if($result->num_rows == 1){
                $row = $result->fetch_assoc();

                // Guarda los datos del usuario en la variable $_session
                $_SESSION['rut_cliente'] = $row['rut_cliente'];
                $_SESSION['nombre_cliente'] = $row['nombre_cliente'];
                $_SESSION['clave'] = $row['clave'];
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
                // Dependiendo del rol, envía a pag administrador o página cliente
                if($_SESSION['rol'] == "Administrador"){
                    ?>
                    <script>           
                        Swal.fire({
                        title: "Datos correctos",
                        text: "Ingresando como administrador...",
                        icon: "success"
                        });
                    </script>     
                    <?php 
                    header("Location: Administracion.php");  

                }else if($_SESSION['rol'] == "Cliente"){
                    ?>
                    <script>           
                        Swal.fire({
                        title: "Datos correctos",
                        text: "Ingresando...",
                        icon: "success"
                        });
                    </script>     
                    <?php 
                    header("Location: PagCliente.php");  
                }               
             
        }else{          
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