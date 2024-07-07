<!DOCTYPE html>
<html lang="es">

<?php

use LDAP\Result;

 include 'layouts/session.php'; ?>
<?php include 'layouts/main.php'; ?>

<?php
    include("modelo/conexion_bd.php");

    $conn = $conexion;

    $sql = "SELECT *
    FROM pedido 
    JOIN medios_de_pago ON pedido.id_medio_pago = medios_de_pago.id_medio_pago 
    JOIN cliente ON pedido.rut_cliente = cliente.rut_cliente
    JOIN detalle_pedido ON pedido.id_pedido = detalle_pedido.id_pedido
    JOIN lista_2 ON lista_2.id_lista_2 = detalle_pedido.id_lista_2
    ORDER BY pedido.id_pedido";
    $result = $conn->query($sql);
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

    <?php include 'layouts/head-css.php'; ?>

</head>

<style>
    @import url(https://fonts.googleapis.com/css2?family=Barlow:wght@100&display=swap);
    @import url(https://fonts.googleapis.com/css2?family=Barlow:wght@700&display=swap);
    @import url(https://fonts.googleapis.com/css2?family=Barlow:ital,wght@1,500&display=swap);
    @import url(https://fonts.googleapis.com/css2?family=Aleo&display=swap);
    @import url(https://fonts.googleapis.com/css2?family=Barlow:ital,wght@1,600&display=swap);

    .inicio{
        width: 1440px; 
        height: 1024px; 
    }
</style>

<body>
    <!-- Agrega el sidebar y topbar -->
    <?php include 'includes/sidebar.php'; ?>
    <?php include 'includes/topbar.php'; ?>

    <!-- Begin page -->
        <div id="layout-wrapper">
            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">

                        <div class="row">
                            <div class="col">
                                <div class="h-100">
                                    <div class="row mb-3 pb-1">
                                        <div class="col-12">
                                            <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                                                <div class="flex-grow-1">
                                                    <h4 class="fs-16 mb-1">¡Bienvenido, Administrador!</h4>
                                                    <p class="text-muted mb-0">Estos son los reportes de "Mi Colegio".</p>
                                                </div>                        
                                            </div><!-- end card header -->
                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end row-->

                                    <div class="row">
                                        <div class="col-xl-3 col-md-6">
                                            <!-- card -->
                                            <div class="card card-animate">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-grow-1 overflow-hidden">
                                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total recaudado</p>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                                        <div class="fs-22 fw-semibold ff-secondary mb-4">
                                                            <?php 
                                                                 include("modelo/conexion_bd.php");

                                                                 $conn = $conexion;
                                                             
                                                                 $sqlsum = "SELECT sum(precio_total) as 'precio_total' FROM pedido";
                                                                 $resultsum = mysqli_query($conn, $sqlsum);
                                                                 $data=mysqli_fetch_array($resultsum);
                                                                 $total = $data['precio_total'];
                                                                 echo '$'.$total;
                                                            ?>
                                                        </div>
                                                        <div class="avatar-sm flex-shrink-0">
                                                            <span class="avatar-title bg-primary-subtle rounded fs-3">
                                                                <i class="bx bx-dollar-circle text-primary"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div><!-- end card body -->
                                            </div><!-- end card -->
                                        </div><!-- end col -->

                                        <div class="col-xl-3 col-md-6">
                                            <!-- card -->
                                            <div class="card card-animate">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-grow-1 overflow-hidden">
                                                         <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Número de pedidos</p>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                                        <div>
                                                            <div class="fs-22 fw-semibold ff-secondary mb-4">
                                                            <?php 
                                                                 include("modelo/conexion_bd.php");

                                                                 $conn = $conexion;
                                                             
                                                                 $sqlcount = "SELECT count(*) as 'total' FROM pedido";
                                                                 $resultcount = mysqli_query($conn, $sqlcount);
                                                                 $datacount=mysqli_fetch_array($resultcount);
                                                                 $totalcount = $datacount['total'];
                                                                 echo $totalcount;
                                                            ?>
                                                            </div>
                                                        </div>
                                                        <div class="avatar-sm flex-shrink-0">
                                                            <span class="avatar-title bg-info-subtle rounded fs-3">
                                                                <i class="bx bx-shopping-bag text-info"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div><!-- end card body -->
                                            </div><!-- end card -->
                                        </div><!-- end col -->

                                        <div class="col-xl-3 col-md-6">
                                            <!-- card -->
                                            <div class="card card-animate">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-grow-1 overflow-hidden">
                                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Número de clientes</p>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                                        <div>
                                                            <div class="fs-22 fw-semibold ff-secondary mb-4">
                                                                <?php 
                                                                    include("modelo/conexion_bd.php");

                                                                    $conn = $conexion;
                                                                
                                                                    $sqlcountclientes = "SELECT count(*) as 'total' FROM cliente";
                                                                    $resultcountclientes = mysqli_query($conn, $sqlcountclientes);
                                                                    $datacountclientes=mysqli_fetch_array($resultcountclientes);
                                                                    $totalcountclientes = $datacount['total'];
                                                                    echo $totalcountclientes;
                                                                ?>
                                                                </div>
                                                        </div>
                                                        <div class="avatar-sm flex-shrink-0">
                                                            <span class="avatar-title bg-primary-subtle rounded fs-3">
                                                                <i class="bx bx-user-circle text-primary"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div><!-- end card body -->
                                            </div><!-- end card -->
                                        </div><!-- end col -->

                                        <div class="col-xl-3 col-md-6">
                                            <!-- card -->
                                            <div class="card card-animate">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-grow-1 overflow-hidden">
                                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> WIP</p>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                                        <div>
                                                            <!-- ESPACIO PARA RELLENAR CON TABLA/GRÁFICO O DEJAR EN BLANCO -->
                                                            <h4 class="fs-22 fw-semibold ff-secondary mb-4">$<span class="counter-value" data-target="165.89">0</span>k </h4>
                                                        </div>
                                                        <div class="avatar-sm flex-shrink-0">
                                                            <span class="avatar-title bg-info-subtle rounded fs-3">
                                                                <i class="bx bx-wallet text-info"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div><!-- end card body -->
                                            </div><!-- end card -->
                                        </div><!-- end col -->
                                    </div> <!-- end row-->                          

                                    <div class="row">                                       
                                        <div class="col-xl-8">
                                            <div class="card">
                                                <div class="card-header align-items-center d-flex">
                                                    <h4 class="card-title mb-0 flex-grow-1">Ordenes recientes</h4>
                                                </div><!-- end card header -->

                                                <div class="card-body">
                                                    <div class="table-responsive table-card">
                                                        <table class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                                            <thead class="text-muted table-light">
                                                                <tr>
                                                                <th style="visibility:collapse; display:none;" scope="col">ID</th>
                                                                <th scope="col">Total</th>
                                                                <th scope="col">Medio de pago</th>
                                                                <th scope="col">RUT cliente</th>
                                                                <th scope="col">Nombre cliente</th>
                                                                <th scope="col">Estado</th>

                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                 <?php while ($row = $result->fetch_assoc()): ?>
                                                    <tr>
                                                        <td style="visibility:collapse; display:none;"><a href='#' class='fw-medium'><?=  $row['id_pedido'] ?></a></td>
                                                        <td> $<?= $row['precio_total'] ?></td>
                                                        <td> <?= $row['nombre_medio_pago'] ?></td>
                                                        <td> <?= $row['rut_cliente'] ?></td>
                                                        <td> <?= $row['nombre_cliente'] ?></td>
                                                        <?php $color_estado = ($row['estado'] == 'Pendiente') ? 'badge bg-danger' : 'badge bg-success'; 
                                                        // Verifica el resultado de la consulta, si el resultado es 'Pendiente', 
                                                        // se guarda 'badge bg-danger, el cual es la clase del span, con el color naranjo,
                                                        // En la derecha se pone si la condición es verdadera, 
                                                        // Si es falsa, corresponderá a 'Finalizado', el cual será la la clase con span verde
                                                        // Luego se pone la variable guardada en la clase del span, con verde o naranjo ?>
                                                        <td><span class='<?= $color_estado ?>'> <?= $row['estado'] ?></span></td>
                                                    </tr>
                                                    <?php endwhile; ?>    
                                                            </tbody><!-- end tbody -->
                                                        </table><!-- end table -->
                                                    </div>
                                                </div>
                                            </div> <!-- .card-->
                                        </div> <!-- .col-->
                                    </div> <!-- end row-->

                                </div> <!-- end .h-100-->

                            </div> <!-- end col -->
                        </div>

                    </div>
                    <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        <?php include 'layouts/vendor-scripts.php'; ?>

        <!-- apexcharts -->
        <script src="assets/libs/apexcharts/apexcharts.min.js"></script>

        <!-- Vector map-->
        <script src="assets/libs/jsvectormap/js/jsvectormap.min.js"></script>
        <script src="assets/libs/jsvectormap/maps/world-merc.js"></script>

        <!--Swiper slider js-->
        <script src="assets/libs/swiper/swiper-bundle.min.js"></script>

        <!-- Dashboard init -->
        <script src="assets/js/pages/dashboard-ecommerce.init.js"></script>

        <!-- App js -->
        <script src="assets/js/app.js"></script>

</body>
</html>