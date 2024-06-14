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
    // Verificar si está el id en la URL para saber si la inserción está correcta
    if (isset($_GET['nombre_categoria'])) {
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>';
        echo '<script>
                Swal.fire({
                    icon: "success",
                    title: "¡Éxito!",
                    text: "Categoría ingresada correctamente.",
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = "../../Productos.php";
                });
            </script>';
    } else {
        // Si no hay id en la URL, muestra mensaje de error y redirecciona a la página de colegios
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>';
        echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Hubo un error al ingresar la categoría.",
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = "../../Productos.php";
                });
            </script>';
        exit();
    }
    ?>
</body>
</html>
