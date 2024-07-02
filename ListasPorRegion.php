<!DOCTYPE html>
<html lang="es">

<?php include 'layouts/session.php'; ?>
<?php include 'layouts/main.php'; ?>

<?php
    include("modelo/conexion_bd.php");

    $conn = $conexion;

    $rut_cliente = $_SESSION['rut_cliente'];

    // Obtener el ID del colegio desde la URL
    $id_curso = $_GET['id_curso'];
    $id_colegio = $_GET['id_colegio'];

    $sql = "SELECT *
    FROM lista_1 
    JOIN l1_productos ON lista_1.id_lista_1 = l1_productos.id_lista_1
    JOIN productos ON productos.id_producto = l1_productos.id_producto
    JOIN curso ON lista_1.id_curso = curso.id_curso 
    JOIN colegio ON curso.id_colegio = colegio.id_colegio
    WHERE lista_1.id_curso = ". $id_curso . " AND lista_1.id_colegio = ". $id_colegio;
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $product = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $product = false;
    }

    // CONSULTA PARA MOSTRAR LOS DATOS DEL COLEGIO Y CURSO
    $sqlCurso = "SELECT *
    FROM lista_1 
    JOIN curso ON lista_1.id_curso = curso.id_curso 
    JOIN colegio ON curso.id_colegio = colegio.id_colegio
    WHERE lista_1.id_curso = ". $id_curso . " AND lista_1.id_colegio = ". $id_colegio;
    $resultCurso = $conn->query($sqlCurso);
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Colegio</title>
    <link rel="icon" type="icon" href="micolegioImg/logo.png"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php includeFileWithVariables('layouts/title-meta.php', array('title' => 'Dashboard')); ?>

    <!-- jsvectormap css -->
    <link href="assets/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css" />

    <!--Swiper slider css-->
    <link href="assets/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css" />

    <!-- swiper css -->
    <link rel="stylesheet" href="assets/libs/swiper/swiper-bundle.min.css">

    <?php include 'layouts/head-css.php'; ?>

</head>

<style>
    button:hover{
        border-color: blue;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.20);
    }

    .card:hover{
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.20);
    }

    .btn:hover{
        box-shadow: inset 0 0 0 50px #695EEF;
    }
</style>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <!-- Agrega el sidebar y topbar -->
        <?php include 'includes/sidebar2.php'; ?>
        <?php include 'includes/topbarCliente.php'; ?>

            <div class="page-content">
                <div class="container-fluid">

                    <div class="position-relative mx-n4 mt-n4">
                        <div class="profile-wid-bg profile-setting-img" >
                            <img src="micolegioImg/fondoColegiosCliente.png" class="profile-wid-img" alt="">
                            <div class="overlay-content">
                                <div class="text-end p-3">
                                    <div class="p-0 ms-auto rounded-circle profile-photo-edit">
                                        <input id="profile-foreground-img-file-input" type="file" class="profile-foreground-img-file-input">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        
                        <div class="col-xxl-9">
                            <div class="card mt-xxl-n5">
                                <div class="card-header">
                                    <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab">
                                                <i class="fas fa-home"></i> PRODUCTOS DE LA LISTA
                                            </a>
                                        </li>  
                                        <li class="nav-item ms-auto">                                                
                                            
                                        </li>                   
                                    </ul>
                                </div>

                                <div class="row mb-3">

                                    <div class="col-xl-8">

                                        <div class="card-body p-4">

                                            <form method="post" action="procesarLista2PagCliente">
                                                <div class="d-flex justify-content-end" style="margin-bottom: 25px;">
                                                    <button type='submit' class='btn btn-info add-btn' 
                                                    data-bs-toggle='modal' id="create-btn" data-bs-target='#exampleModalgrid' 
                                                    style="background-color:darkslateblue; font-size:20px" >
                                                    <i class="ri-add-line align-bottom me-1"></i><i class="fas fa-home"></i> Añadir toda la lista al carro</button>
                                                </div>
                                                
                                                <?php // VARIABLE PARA PONER EL TOTAL DE LA LISTA
                                                $total = 0; ?>                                                           

                                                <?php if ($product !== false && is_array($product)) : ?>

                                                    <!-- INPUTS PARA AÑADIR UNA NUEVA LISTA 2 CON EL ID_CURSO E ID_COLEGIO -->
                                                    <!-- INPUTS INVISIBLES RELLENADOS CON LOS ID de colegio y curso -->
                                                    <?php 
                                                    $id_curso = $product[0]['id_curso'];
                                                    $id_colegio = $product[0]['id_colegio'];
                                                    ?>
                                                    <input type="hidden" name="id_colegio" value="<?= $id_colegio ?>">
                                                    <input type="hidden" name="id_curso" value="<?= $id_curso ?>">
                                                    <input type="hidden" name="rut_cliente" value="<?= $rut_cliente ?>">

                                                    <?php 
                                                    $total = 0;

                                                    foreach ($product as $index => $products) : 
                                                        // FOREACH PARA INGRESAR TODOS LOS PRODUCTOS DEL RESULTADO
                                                        $dir = $products['dir'];
                                                        $id_producto = $products['id_producto'];
                                                        $nombre_producto = $products['nombre_producto'];
                                                        $precio = $products['precio'];
                                                        $cantidad = $products['cantidad'];
                                                        $subtotal = $precio * $cantidad;
                                                        $total += $subtotal;
                                                        $id_curso = $products['id_curso'];
                                                    ?>

                                                    <div class="tab-content">
                                                        <div class="card product">
                                                            <div class="card-body">
                                                                <div class="row gy-3">
                                                                    <div class="col-sm-auto">
                                                                        <div class="avatar-lg bg-light rounded p-1">
                                                                            <img src="<?= $dir ?>" alt="" class="img-fluid d-block">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm">
                                                                        <h5 class="fs-14 text-truncate"><a href="#" class="text-body"><?= $nombre_producto ?></a></h5>
                                                                        <input type="text" class="form-control" id="nombre_producto" name="nombre_producto" value="<?= $nombre_producto ?>" style="display: none;" >

                                                                        <ul class="list-inline text-muted">
                                                                            <li class="list-inline-item">Cantidad : <span class="fw-medium"><?= $cantidad ?></span></li>
                                                                            <!-- INPUTS INVISIBLES RELLENADOS CON LOS DATOS PARA INGRESARLOS A LA BASE DE DATOS Y MOSTRARLOS EN EL CARRO DE COMPRAS -->
                                                                            <input type="hidden" name="productos[<?= $index ?>][id_producto]" value="<?= $id_producto ?>">
                                                                            <input type="hidden" name="productos[<?= $index ?>][id_curso]" value="<?= $id_curso ?>">
                                                                            <input type="hidden" name="productos[<?= $index ?>][estado]" value="Pendiente">
                                                                            <input type="hidden" name="productos[<?= $index ?>][rut_cliente]" value="<?= $_SESSION['rut_cliente'] ?>">

                                                                        </ul>

                                                                        <div class="input-step">
                                                                            <button type="button" class="minus">–</button>
                                                                            <input type="number" class="product-quantity" name="productos[<?= $index ?>][cantidad]" value="<?= $cantidad ?>" min="1" max="100">
                                                                            <button type="button" class="plus">+</button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-auto">
                                                                        <div class="text-lg-end">
                                                                            <p class="text-muted mb-1">Precio:</p>
                                                                            <h5 class="fs-14">$<span class="product-price"><?= $precio ?></span></h5>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- card body -->
                                                            <div class="card-footer">
                                                                <div class="row align-items-center gy-3">
                                                                    <div class="col-sm">
                                                                        <div class="d-flex flex-wrap my-n1">
                                                                            <div>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-auto">
                                                                        <div class="d-flex align-items-center gap-2 text-muted">
                                                                            <div>Subtotal :</div>
                                                                            <h5 class="fs-14 mb-0">$<span class="product-line-price"><?= $subtotal ?></span></h5>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- end card footer -->
                                                        </div>
                                                        <!-- end card -->

                                                    <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </div>
                <!-- container-fluid -->            
            </div><!-- End Page-content -->

            <div class="col-xxl-3">
                <div class="card mt-n5">
                    <div class="card-body p-4">
                        <div class="text-center">
                            <?php while ($row = $resultCurso->fetch_assoc()): ?>
                                <p class="fs-16 mb-1" style="font-size: 25px;"><?= $row['nombre_l1'] ?></p>
                                <h5 class="fs-16 mb-1"><?= $row['nombre_curso'] ?></h5>
                                <h5 class="fs-16 mb-1"><?= $row['nombre_de_colegio'] ?></h5>

                                <div class="mx-auto avatar-md mb-3" style="margin-top: 30px;">
                                    <img src="micolegioImg/logo.png" alt="" class="img-fluid rounded-circle">
                                </div>
                                
                            <?php endwhile; ?>
                            <p class="mb-0" style="color: blue; font-size:20px">Total de la lista $<?= $total ?></p>

                            <div style="margin-top: 30px;">
                                <a href="ProductosPagCliente.php">
                                    <button type='submit' class='btn btn-info add-btn' 
                                    data-bs-toggle='modal' id="create-btn" data-bs-target='#exampleModalgrid' 
                                    style="background-color:blueviolet; font-size:15px" >
                                    <i class="ri-add-line align-bottom me-1"></i><i class="fas fa-home"></i> Añadir productos extra</button>
                                </a>               
                            </div>
                        </div>
                    </div>
                </div>
                <!--end card-->                     
             </div>
            <!--end col-->
        </div>
        <!-- end main content-->
    </div>

    <?php include 'layouts/vendor-scripts.php'; ?>
    <?php include 'includes/footerCliente.php'; ?>

    <!-- profile-setting init js -->
    <script src="assets/js/pages/profile-setting.init.js"></script>

    <!-- App js -->
    <script src="assets/js/app.js"></script>

    <!-- input step init -->
    <script src="assets/js/pages/form-input-spin.init.js"></script>

    <!-- ecommerce cart js -->
    <script src="assets/js/pages/ecommerce-cart.init.js"></script>
</body>

</html>