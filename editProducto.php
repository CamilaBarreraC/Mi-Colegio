<!DOCTYPE html>
<html lang="es">

<?php include 'layouts/session.php'; ?>
<?php include 'layouts/main.php'; ?>

<?php
    // Obtener el ID del colegio desde la URL
    $id_producto = $_GET['id_producto'];
    // Llamar al controlador para obtener los datos del colegio
    require_once ('controlador/crud_producto/controlador_producto.php');
    $controlador = new ControladorProducto();
    $producto = $controlador->showProducto($id_producto);
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Colegio</title>
    <link rel="icon" type="icon" href="micolegioImg/logo.png"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- jsvectormap css -->
    <link href="assets/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css" />

    <!--Swiper slider css-->
    <link href="assets/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css" />

    <?php includeFileWithVariables('layouts/title-meta.php', array('title' => 'Starter')); ?>
    <?php include 'layouts/head-css.php'; ?>
    
</head>

<style>
    @import url(https://fonts.googleapis.com/css2?family=Barlow:wght@100&display=swap);
    @import url(https://fonts.googleapis.com/css2?family=Barlow:wght@700&display=swap);
    @import url(https://fonts.googleapis.com/css2?family=Barlow:ital,wght@1,500&display=swap);
    @import url(https://fonts.googleapis.com/css2?family=Aleo&display=swap);
    @import url(https://fonts.googleapis.com/css2?family=Barlow:ital,wght@1,600&display=swap);

    #form{
        font-family: Barlow; 
        font-weight: 800;
    }
</style>

<body>
    <!-- Agrega el sidebar y topbar -->
    <?php include 'includes/sidebar.php'; ?>
    <?php include 'includes/topbar.php'; ?>

    <!-- Begin page -->
    <div id="layout-wrapper">
        <!-- PÁGINA PARA EDITAR DATOS DEL PEDIDO -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <div id="container" tabindex="-1" >
                        <div class="">
                            <h5 id="exampleModalgridLabel" style="color: rgba(105, 94, 239, 1);font-size:30px; margin-bottom: 20px">ID Producto: <?= $id_producto ?></h5>
                        </div>
                        <div class="">
                            <?php if ($producto): ?>
                            <form action="updateProducto.php" method="post">
                                <div class="row g-3">
                                    <div class='col-xxl-6'>
                                        <div>    
                                            <label for='id_producto' class='form-label' >ID producto</label>
                                            <input type='text' class='form-control' name="id_producto" id="id_producto" value="<?= $producto['id_producto'] ?>" readonly>                           
                                        </div>
                                    </div>
                                    
                                    <div class="col-xxl-6">
                                        <div>
                                            <label for="nombre_producto" class="form-label" style="margin-top: 0px;">Nombre producto</label>
                                            <input type='text' class='form-control' name="nombre_producto" id="nombre_producto" value="<?= $producto['nombre_producto'] ?>">                           
                                        </div>
                                    </div><!--end col-->

                                    <div class="col-xxl-6">
                                        <div>
                                            <label for="choices-single-default" class="form-label">Categoría</label>
                                            <select class="form-control" data-choices name="id_categoria" id="choices-single-default" required>
                                                <option value="<?= $producto['id_categoria'] ?>"><?= $producto['nombre_categoria'] ?></option>
                                                <?php
                                                // Establecer conexión a la base de datos
                                                include("modelo\conexion_bd.php");

                                                // Consulta SQL para obtener las opciones
                                                $sql = "SELECT id_categoria, nombre_categoria FROM categoria";
                                                $resultCat = $conexion->query($sql);

                                                // Confirma si hay resultados, ordenandolos por id 
                                                // Si no hay datos, muestra la opción de no hay registros
                                                if ($resultCat->num_rows > 0){
                                                    while($row = $resultCat->fetch_assoc()) {
                                                        echo "<option value='" . $row["id_categoria"] . "'>" . $row["nombre_categoria"] . "</option>";
                                                    }
                                                }else{
                                                    echo "<option value=''>No hay registros de categorías</option>";
                                                }

                                                $conexion->close();
                                                ?>
                                            </select>
                                        </div>
                                    </div><!--end col-->

                                    <div class="col-xxl-6">
                                        <div>
                                            <label for="precio" class="form-label" style="margin-top: 0px;">Precio</label>
                                            <input type='number' class='form-control' name="precio" id="precio" value="<?= $producto['precio'] ?>">                           
                                        </div>
                                    </div><!--end col-->

                                    <div class="col-xxl-6">
                                        <div>
                                            <label for="formFile" class="form-label" style="margin-top: 0px;">Imagen</label>
                                            <input class="form-control" type="file" id="imagen" name="imagen" value="<?=$producto['dir'] ?>">
                                         </div>
                                     </div><!--end col-->

                                    <div class="col-lg-12">
                                        <div class="hstack gap-2 justify-content-end">
                                            <a href="Productos.php">
                                                <button type="button" class="btn btn-light">Volver</button>
                                            </a>
                                            <button type="submit" class="btn btn-primary" value="Actualizar">Actualizar</button>
                                        </div>
                                    </div><!--end col-->
                                </div><!--end row-->
                            </form>
                            <?php endif; ?>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>

    <?php include 'layouts/vendor-scripts.php'; ?>
    <!-- prismjs plugin -->
    <script src="assets/libs/prismjs/prism.js"></script>
    <script src="assets/libs/list.js/list.min.js"></script>
    <script src="assets/libs/list.pagination.js/list.pagination.min.js"></script>

    <!-- listjs init -->
    <script src="assets/js/pages/listjs.init.js"></script>

    <!-- Sweet Alerts js -->
    <script src="assets/libs/sweetalert2/sweetalert2.min.js"></script>

    <!-- App js -->
    <script src="assets/js/app.js"></script>
</body>
</html>