<!DOCTYPE html>
<html lang="es">

<?php include 'layouts/session.php'; ?>
<?php include 'layouts/main.php'; ?>

<?php
    // Obtener el ID del colegio desde la URL
    $id_lista_1_productos = $_GET['id_lista_1_productos'];
    // Llamar al controlador para obtener los datos del colegio
    require_once ('controlador/crud_lista1productos/controlador_lista1productos.php');
    $controlador = new ControladorProductoLista1();
    $productolista1 = $controlador->showLista1Productos($id_lista_1_productos);
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
                            <h5 id="exampleModalgridLabel" style="color: rgba(105, 94, 239, 1);font-size:30px; margin-bottom: 20px">ID Producto: <?= $id_lista_1_productos ?></h5>
                        </div>
                        <div class="">
                            <?php if ($productolista1): ?>
                            <form action="updateLista1Productos.php" method="post">
                                <div class="row g-3">
                                    <div class='col-xxl-6'>
                                        <div>    
                                            <label for='id_lista_1_productos' class='form-label' >ID producto</label>
                                            <input type='text' class='form-control' name="id_lista_1_productos" id="id_lista_1_productos" value="<?= $productolista1['id_lista_1_productos'] ?>" readonly>                           
                                        </div>
                                    </div>

                                    <div class="col-xxl-6">
                                        <div>
                                            <label for="choices-single-default" class="form-label">Producto</label>
                                            <select class="form-control" data-choices name="id_producto" id="choices-single-default" required>
                                                <option value="<?= $productolista1['id_producto'] ?>"><?= $productolista1['nombre_producto'] ?></option>
                                                <?php
                                                // Establecer conexión a la base de datos
                                                include("modelo\conexion_bd.php");

                                                // Consulta SQL para obtener las opciones
                                                $sql = "SELECT id_producto, nombre_producto FROM productos";
                                                $resultCat = $conexion->query($sql);

                                                // Confirma si hay resultados, ordenandolos por id 
                                                // Si no hay datos, muestra la opción de no hay registros
                                                if ($resultCat->num_rows > 0){
                                                    while($row = $resultCat->fetch_assoc()) {
                                                        echo "<option value='" . $row["id_producto"] . "'>" . $row["nombre_producto"] . "</option>";
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
                                            <label for="cantidad" class="form-label" style="margin-top: 0px;">Cantidad</label>
                                            <input type='number' class='form-control' name="cantidad" id="cantidad" value="<?= $productolista1['cantidad'] ?>">                           
                                        </div>
                                    </div><!--end col-->

                                    <div class="col-xxl-6">
                                        <div>
                                            <label for="id_lista_1" class="form-label" style="margin-top: 0px;">ID lista</label>
                                            <input type='text' class='form-control' name="id_lista_1" id="id_lista_1" value="N°<?= $productolista1['id_lista_1'] . " " . $productolista1['nombre_l1']?>" readonly>                           
                                        </div>
                                    </div><!--end col-->

                                    <div class="col-lg-12">
                                        <div class="hstack gap-2 justify-content-end">
                                            <a href="productoLista1.php">
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