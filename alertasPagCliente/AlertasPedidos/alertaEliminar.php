<!DOCTYPE html>
<html lang="es">

<!-- ALERTAS EN OTRA PAG PORQUE NO ME FUNCIONAN LAS ALERTAS EN EL MVC -->

<head>
    <title>Mi Colegio</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>

<style>
    @import url(https://fonts.googleapis.com/css2?family=Barlow:wght@100&display=swap);
    @import url(https://fonts.googleapis.com/css2?family=Barlow:wght@700&display=swap);
    @import url(https://fonts.googleapis.com/css2?family=Barlow:ital,wght@1,500&display=swap);
    @import url(https://fonts.googleapis.com/css2?family=Aleo&display=swap);
    @import url(https://fonts.googleapis.com/css2?family=Barlow:ital,wght@1,600&display=swap);

    *{
        font-family: Barlow; 
        font-style: italic; 
        font-weight: 800; ;
    }

</style>

<body>
    <?php
    // En el caso de delete, se mostrará mensaje de error si aún existe un ID
    // Si no envía un ID, significa que se eliminó correctamente
    if (isset($_GET['id_pedido'])) {
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>';
        echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Hubo un error al eliminar el pedido.",
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = "../../Pedidos.php";
                });
            </script>';
    } else {
        // Si no hay id en la URL, muestra alerta y redirecciona a la página de pedidos
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>';
        echo '<script>
                Swal.fire({
                    icon: "success",
                    title: "¡Eliminado!",
                    text: "Pedido eliminado correctamente.",
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = "../../Pedidos.php";
                });
            </script>';
        exit();
    }
    ?>
</body>
</html>
