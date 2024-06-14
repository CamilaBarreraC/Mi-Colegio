
<?php

    $conexion = mysqli_connect("localhost","root","ipchile","mi_colegio");
    $conexion->set_charset("utf8");
    
    // Verificar la conexión
    if (!$conexion) {
        ?>
            <script>         
                Swal.fire({
                icon: "error",
                title: "<h3 style='font-family: Barlow; font-style: italic'>La conexión falló</h3>",
                text: mysqli_connect_error()
                });
            </script>
        <?php 
    }else{
        ?>
            <script>         
                Swal.fire({
                icon: "error",
                title: "<h3 style='font-family: Barlow; font-style: italic'>La conexión falló</h3>",
                text: mysqli_connect_error()
                });
            </script>
        <?php 
    }

?>