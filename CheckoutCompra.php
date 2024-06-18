<!DOCTYPE html>
<html lang="es">

<?php include 'layouts/session.php'; ?>
<?php include 'layouts/main.php'; ?>

<?php

    include("modelo/conexion_bd.php");

    $conn = $conexion;

    $rut_cliente = $_SESSION['rut_cliente'];

    // Llamar al controlador para obtener los datos del usuario
    require_once ('controlador/crud_cliente/controlador_cliente.php');
    $controlador = new ControladorCliente();
    $usuario = $controlador->show($rut_cliente);

    $sql = "SELECT *
    FROM lista_2 
    JOIN curso ON lista_2.id_curso = curso.id_curso
    JOIN colegio ON curso.id_colegio = colegio.id_colegio
    JOIN l2_productos ON lista_2.id_curso = l2_productos.id_curso 
    JOIN cliente ON lista_2.rut_cliente = cliente.rut_cliente
    JOIN productos ON l2_productos.id_producto = productos.id_producto
    JOIN categoria ON categoria.id_categoria = productos.id_categoria
    WHERE lista_2.rut_cliente = ". $rut_cliente;

    $result = $conn->query($sql);

    $sqlCurso = "SELECT *
    FROM productos_extra 
    JOIN cliente ON productos_extra.rut_cliente = cliente.rut_cliente
    JOIN productos ON productos_extra.id_producto = productos.id_producto
    JOIN categoria ON productos.id_categoria = categoria.id_categoria
    WHERE productos_extra.rut_cliente = ". $rut_cliente;
    $resultCurso = $conn->query($sqlCurso);

    // Variable para el total
    $total = 0; 

    // Variable para mostrar cuántos productos hay en el carro de compras
    $totalProductos = $result->num_rows + $resultCurso->num_rows;

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

<body>
    <!-- Begin page -->
    <div id="layout-wrapper">

        <!-- Agrega el sidebar y topbar -->
        <?php include 'includes/sidebar2.php'; ?>
        <?php include 'includes/topbarCliente.php'; ?>

            <div class="page-content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-xl-8">
                            <div class="card">
                                <div class="card-body checkout-tab">

                                    <form action="#">
                                        <div class="step-arrow-nav mt-n3 mx-n3 mb-3">

                                            <ul class="nav nav-pills nav-justified custom-nav" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link fs-15 p-3 active" id="pills-bill-info-tab" data-bs-toggle="pill" data-bs-target="#pills-bill-info" type="button" role="tab" aria-controls="pills-bill-info" aria-selected="true">
                                                        <i class="ri-user-2-line fs-16 p-2 bg-primary-subtle text-primary rounded-circle align-middle me-2"></i> Información
                                                    </button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link fs-15 p-3" id="pills-bill-address-tab" data-bs-toggle="pill" data-bs-target="#pills-bill-address" type="button" role="tab" aria-controls="pills-bill-address" aria-selected="false">
                                                        <i class="ri-truck-line fs-16 p-2 bg-primary-subtle text-primary rounded-circle align-middle me-2"></i> Dirección 
                                                    </button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link fs-15 p-3" id="pills-payment-tab" data-bs-toggle="pill" data-bs-target="#pills-payment" type="button" role="tab" aria-controls="pills-payment" aria-selected="false">
                                                        <i class="ri-bank-card-line fs-16 p-2 bg-primary-subtle text-primary rounded-circle align-middle me-2"></i> Medio de pago
                                                    </button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link fs-15 p-3" id="pills-finish-tab" data-bs-toggle="pill" data-bs-target="#pills-finish" type="button" role="tab" aria-controls="pills-finish" aria-selected="false">
                                                        <i class="ri-checkbox-circle-line fs-16 p-2 bg-primary-subtle text-primary rounded-circle align-middle me-2"></i> Pedido
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="tab-content">
                                            <div class="tab-pane fade show active" id="pills-bill-info" role="tabpanel" aria-labelledby="pills-bill-info-tab">
                                                <div style="margin-bottom: 30px;">
                                                    <h4 class="mb-1">Información personal</h4>
                                                    <h8 class="mb-1">Verifique que la información esté correcta </h8>
                                                </div>

                                                <div>
                                                    <?php if ($usuario): ?>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="billinginfo-firstName" class="form-label">Nombres</label>
                                                                <input type="text" class="form-control" id="billinginfo-firstName" name="nombre_cliente" placeholder="Ingrese nombre" value="<?= $usuario['nombre_cliente'] ?>" readonly>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="billinginfo-lastName" class="form-label">Apellidos</label>
                                                                <input type="text" class="form-control" id="billinginfo-lastName" name="apellido_cliente" placeholder="Ingrese apellido" value="<?= $usuario['apellido_cliente'] ?>" readonly>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="billinginfo-email" class="form-label">RUT </label>
                                                                <input type="text" class="form-control" id="billinginfo-email" placeholder="Ingrese RUT" value="<?= $usuario['rut_cliente'] ?>" readonly>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="billinginfo-email" class="form-label">Email </label>
                                                                <input type="email" class="form-control" id="billinginfo-email" placeholder="Ingrese email" value="<?= $usuario['email'] ?>" readonly>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="mb-3">
                                                                <label for="country" class="form-label">Región</label>
                                                                <input type="text" class="form-control" id="country" placeholder="Ingrese región" value="<?= $usuario['nombre_region'] ?>" readonly>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="mb-3">
                                                                <label for="state" class="form-label">Comuna</label>
                                                                <input type="text" class="form-control" id="state" placeholder="Ingrese comuna" value="<?= $usuario['nombre_comuna'] ?>" readonly>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="mb-3">
                                                                <label for="billinginfo-phone" class="form-label">Teléfono</label>
                                                                <input type="text" class="form-control" id="billinginfo-phone" placeholder="Ingrese teléfono" value="<?= $usuario['telefono'] ?>" readonly>
                                                            </div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="billinginfo-address" class="form-label">Dirección</label>
                                                            <input class="form-control" id="billinginfo-address" placeholder="Ingrese dirección" value="<?= $usuario['direccion'] ?>"></input>
                                                        </div>
                                                    </div>

                                                    <div class="d-flex align-items-start gap-3 mt-3">
                                                        <button type="button" class="btn btn-primary btn-label right ms-auto nexttab" data-nexttab="pills-bill-address-tab">
                                                            <i class="ri-truck-line label-icon align-middle fs-16 ms-2"></i>Continuar
                                                        </button>
                                                    </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <!-- end tab pane -->

                                            <div class="tab-pane fade" id="pills-bill-address" role="tabpanel" aria-labelledby="pills-bill-address-tab">
                                                <div>
                                                    <h5 class="mb-1">Dirección</h5>
                                                    <p class="text-muted mb-4"></p>
                                                </div>

                                                <div class="mt-4">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <div class="flex-grow-1">
                                                            <h5 class="fs-14 mb-0">Se enviará el pedido a esta dirección</h5>
                                                        </div>
                                                        <div class="flex-shrink-0">

                                                        </div>
                                                    </div>
                                                    <div class="row gy-3">
                                                        <div class="col-lg-4 col-sm-6">
                                                            <div class="form-check card-radio">
                                                                <input id="shippingAddress01" name="shippingAddress" type="radio" class="form-check-input" checked>
                                                                <label class="form-check-label" for="shippingAddress01">
                                                                    <span class="mb-4 fw-semibold d-block text-muted text-uppercase">Dirección de su hogar</span>

                                                                    <?php if ($usuario): ?>
                                                                        <span class="fs-14 mb-2 d-block"><?= $usuario['nombre_cliente'] ?> <?= $usuario['apellido_cliente'] ?></span>
                                                                        <span class="text-muted fw-normal text-wrap mb-1 d-block"><?= $usuario['direccion'] ?></span>
                                                                        <span class="text-muted fw-normal d-block">Región: <?= $usuario['nombre_region'] ?> 
                                                                        <br>Comuna:  <?= $usuario['nombre_comuna'] ?></span>
                                                                    <?php endif; ?>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="d-flex align-items-start gap-3 mt-4">
                                                    <button type="button" class="btn btn-light btn-label previestab" data-previous="pills-bill-info-tab"><i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>Volver</button>
                                                    <button type="button" class="btn btn-primary btn-label right ms-auto nexttab" data-nexttab="pills-payment-tab"><i class="ri-bank-card-line label-icon align-middle fs-16 ms-2"></i>Continuar</button>
                                                </div>
                                            </div>
                                            <!-- end tab pane -->

                                            <div class="tab-pane fade" id="pills-payment" role="tabpanel" aria-labelledby="pills-payment-tab">
                                                <div>
                                                    <h5 class="mb-1">Medio de pago</h5>
                                                </div>

                                                <div class="row g-4">
                                                    <div class="col-lg-4 col-sm-6">
                                                        <div data-bs-toggle="collapse" data-bs-target="#paymentmethodCollapse.show" aria-expanded="false" aria-controls="paymentmethodCollapse">
                                                            <div class="form-check card-radio">
                                                                <input id="paymentMethod01" name="paymentMethod" type="radio" class="form-check-input">
                                                                <label class="form-check-label" for="paymentMethod01">
                                                                    <span class="fs-16 text-muted me-2"><i class="ri-paypal-fill align-bottom"></i></span>
                                                                    <span class="fs-14 text-wrap">Paypal</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-sm-6">
                                                        <div data-bs-toggle="collapse" data-bs-target="#paymentmethodCollapse" aria-expanded="true" aria-controls="paymentmethodCollapse">
                                                            <div class="form-check card-radio">
                                                                <input id="paymentMethod02" name="paymentMethod" type="radio" class="form-check-input" checked>
                                                                <label class="form-check-label" for="paymentMethod02">
                                                                    <span class="fs-16 text-muted me-2"><i class="ri-bank-card-fill align-bottom"></i></span>
                                                                    <span class="fs-14 text-wrap">Credit / Debit Card</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4 col-sm-6">
                                                        <div data-bs-toggle="collapse" data-bs-target="#paymentmethodCollapse.show" aria-expanded="false" aria-controls="paymentmethodCollapse">
                                                            <div class="form-check card-radio">
                                                                <input id="paymentMethod03" name="paymentMethod" type="radio" class="form-check-input">
                                                                <label class="form-check-label" for="paymentMethod03">
                                                                    <span class="fs-16 text-muted me-2"><i class="ri-money-dollar-box-fill align-bottom"></i></span>
                                                                    <span class="fs-14 text-wrap">Cash on Delivery</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="collapse show" id="paymentmethodCollapse">
                                                    <div class="card p-4 border shadow-none mb-0 mt-4">
                                                        <div class="row gy-3">
                                                            <div class="col-md-12">
                                                                <label for="cc-name" class="form-label">Name on card</label>
                                                                <input type="text" class="form-control" id="cc-name" placeholder="Enter name">
                                                                <small class="text-muted">Full name as displayed on card</small>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <label for="cc-number" class="form-label">Credit card number</label>
                                                                <input type="text" class="form-control" id="cc-number" placeholder="xxxx xxxx xxxx xxxx">
                                                            </div>

                                                            <div class="col-md-3">
                                                                <label for="cc-expiration" class="form-label">Expiration</label>
                                                                <input type="text" class="form-control" id="cc-expiration" placeholder="MM/YY">
                                                            </div>

                                                            <div class="col-md-3">
                                                                <label for="cc-cvv" class="form-label">CVV</label>
                                                                <input type="text" class="form-control" id="cc-cvv" placeholder="xxx">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="text-muted mt-2 fst-italic">
                                                        <i data-feather="lock" class="text-muted icon-xs"></i> Your transaction is secured with SSL encryption
                                                    </div>
                                                </div>

                                                <div class="d-flex align-items-start gap-3 mt-4">
                                                    <button type="button" class="btn btn-light btn-label previestab" data-previous="pills-bill-address-tab"><i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>Volver</button>
                                                    <button type="button" class="btn btn-primary btn-label right ms-auto nexttab" data-nexttab="pills-finish-tab"><i class="ri-shopping-basket-line label-icon align-middle fs-16 ms-2"></i>Complete Order</button>
                                                </div>
                                            </div>
                                            <!-- end tab pane -->

                                            <div class="tab-pane fade" id="pills-finish" role="tabpanel" aria-labelledby="pills-finish-tab">
                                                <div class="text-center py-5">

                                                    <div class="mb-4">
                                                        <lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop" colors="primary:#695eef,secondary:#73dce9" style="width:120px;height:120px"></lord-icon>
                                                    </div>
                                                    <h5>Thank you ! Your Order is Completed !</h5>
                                                    <p class="text-muted">You will receive an order confirmation email with details of your order.</p>

                                                    <h3 class="fw-semibold">Order ID: <a href="apps-ecommerce-order-details.php" class="text-decoration-underline">VZ2451</a></h3>
                                                </div>
                                            </div>
                                            <!-- end tab pane -->
                                        </div>
                                        <!-- end tab content -->
                                    </form>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->

                        <div class="col-xl-4">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <h5 class="card-title mb-0">Pedido</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive table-card">
                                        <table class="table table-borderless align-middle mb-0">
                                            <thead class="table-light text-muted">
                                                <tr>
                                                    <th style="width: 90px;" scope="col">Producto</th>
                                                    <th scope="col">Nombre</th>
                                                </tr>
                                            </thead>
                                            <?php if ($result->num_rows > 0) : ?>

                                            <?php
                                                //Definir variables vacías fuera del while para mostrar el curso y colegio por los productos de una lista
                                                $NomCurso = null;
                                                $NomColegio = null;
                                            ?>

                                            <tbody>
                                                <?php while ($row = $result->fetch_assoc()): ?>      
                                                    <tr>
                                                        <td></td>

                                                        <td>
                                                            <?php //Validador para que no se repitan los nombres de curso y colegio
                                                            // que se muestran en el carro

                                                            if ($row['nombre_curso'] !== $NomCurso || $row['nombre_de_colegio'] !== $NomColegio) : ?>
                                                                <div class="px-2" style="margin-top: 15px; margin-bottom:20px">
                                                                    <h5 class="m-0 fw-normal" style="color:#5c46ea; font-size: 13px">
                                                                        <?php echo $row['nombre_curso']; ?> <?php echo $row['nombre_de_colegio']; ?>
                                                                    </h5>
                                                                </div>
                                                                <?php
                                                                    // Actualiza las variables $prevCurso y $prevColegio con los nombres actuales del while
                                                                    $NomCurso = $row['nombre_curso'];
                                                                    $NomColegio = $row['nombre_de_colegio'];
                                                                ?>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>     
                                                    <tr>
                                                        <td>
                                                            <div class="avatar-md bg-light rounded p-1">
                                                                <img src="<?php echo $row['dir']; ?>" alt="" class="img-fluid d-block" style="width: 95%; height: 100%">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <h5 class="fs-14"><a href="apps-ecommerce-product-details.php" class="text-body"><?php echo $row['nombre_producto']; ?></a></h5>
                                                            <p class="text-muted mb-0">$<?php echo $row['precio']; ?> x <?php echo $row['cantidad']; ?></p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <?php
                                                            // Calcular el subtotal de los productos (cantidad * precio)
                                                            $subtotal = $row['cantidad'] * $row['precio'];
                                                            // Agregar el subtotal al total
                                                            $total += $subtotal; 
                                                        ?>
                                                        <td class="fw-semibold" colspan="2">Sub Total : $ <?= $subtotal ?></td>
                                                    </tr>
                                                <?php endwhile; ?>
                                            <?php endif; ?>

                                                <!-- VALIDADOR PARA VER SI HAY RESULTADOS DE LA CONSULTA -->
                                                <?php if ($resultExtras->num_rows > 0) : ?>   
                                                    <tr>
                                                        <td></td>
                                                        <td>
                                                            <h5 class="m-0 fw-normal" style="font-size: 25px; color:blue">Extras :</h5>
                                                        </td>
                                                    </tr>     

                                                    <!-- WHILE PARA MOSTRAR PRODUCTOS EXTRAS -->
                                                    <?php while ($rowCurso = $resultCurso->fetch_assoc()): ?>
                                                    <tr>
                                                        <td>
                                                            <div class="avatar-md bg-light rounded p-1">
                                                                <img src="<?php echo $rowCurso['dir']; ?>" alt="" class="img-fluid d-block" style="width: 95%; height: 100%">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <h5 class="fs-14"><a href="apps-ecommerce-product-details.php" class="text-body"><?php echo $rowCurso['nombre_producto']; ?></a></h5>
                                                            <p class="text-muted mb-0">$<?php echo $rowCurso['precio']; ?> x <?php echo $rowCurso['cantidad']; ?></p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <?php
                                                            // Calcular el subtotal de los productos (cantidad * precio)
                                                            $subtotal = $rowCurso['cantidad'] * $rowCurso['precio'];
                                                            // Agregar el subtotal al total
                                                            $total += $subtotal; 
                                                        ?>
                                                        <td class="fw-semibold" colspan="2">Sub Total : $ <?= $subtotal ?></td>
                                                    </tr>
                                                
                                                    <?php endwhile; ?>
                                                <?php endif; ?>

                                                <!-- TOTAL COMPRA -->
                                                <tr class="table-active">
                                                    <th colspan="2" style="font-size: 20px; color:blue">Total : $ <?= $total ?></th>
                                                </tr>            
                                            </tbody>
                                           
                                        </table>

                                    </div>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                </div>
            </div>
    </div>

    <?php include 'layouts/vendor-scripts.php'; ?>

    <!-- init js -->
    <script src="assets/js/pages/ecommerce-product-checkout.init.js"></script>

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