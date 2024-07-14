<!DOCTYPE html>
<html lang="es">

<?php include 'layouts/session.php'; ?>
<?php include 'layouts/main.php'; ?>

<?php

    // EXTRAE LA VARIABLE DE LA URL PARA MOSTRAR ALERTA DE RECHAZADO O FONDOS INSUFICIENTES   
    if(isset($_GET['pedido'])){

        if ($_GET['pedido'] === 'rechazado') {
            echo 'a';
            echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>';
            echo '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Datos incorrectos",
                        text: "La tarjeta es inválida.",
                        showConfirmButton: false
                    });
                </script>';
        } elseif ($_GET['pedido'] === 'insuficiente'){
            echo 'a';
            echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>';
            echo '<script>
                    Swal.fire({
                        icon: "warning",
                        title: "Saldo insuficiente",
                        text: "El saldo de su tarjeta es insuficiente.",
                        showConfirmButton: false
                    });
                </script>';
        } elseif ($_GET['pedido'] === 'confirmado'){
            echo 'a';
            echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>';
            echo '<script>
                    Swal.fire({
                        title: "¡Gracias por su compra!",
                        text: "En este enlace puede ver sus pedidos.",
                        html: `
                            <lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop" colors="primary:#695eef,secondary:#73dce9" style="width:120px;height:120px"></lord-icon>
                            <p class="text-muted">En este enlace puede ver sus pedidos.</p>
                            <h3 class="fw-semibold"><a href="DatosUsuario.php" class="text-decoration-underline">Mis pedidos</a></h3>
                        `,
                        showConfirmButton: false
                    });
                </script>';
        }
    }

    include("modelo/conexion_bd.php");

    $conn = $conexion;

    $rut_cliente = $_SESSION['rut_cliente'];

    // Llamar al controlador para obtener los datos del usuario
    require_once ('controlador/crud_cliente/controlador_cliente.php');
    $controlador = new ControladorCliente();
    $usuario = $controlador->show($rut_cliente);

    $sql = "SELECT *
    FROM carro_compras 
    JOIN curso ON carro_compras.id_curso = curso.id_curso
    JOIN colegio ON curso.id_colegio = colegio.id_colegio
    JOIN carro_productos ON carro_compras.id_carro = carro_productos.id_carro 
    JOIN cliente ON carro_compras.rut_cliente = cliente.rut_cliente
    JOIN productos ON carro_productos.id_producto = productos.id_producto
    JOIN categoria ON categoria.id_categoria = productos.id_categoria
    WHERE carro_compras.rut_cliente = ". $rut_cliente;

    $result = $conn->query($sql);

    $sqlCurso = "SELECT *
    FROM carro_productos_extra 
    JOIN cliente ON carro_productos_extra.rut_cliente = cliente.rut_cliente
    JOIN productos ON carro_productos_extra.id_producto = productos.id_producto
    JOIN categoria ON productos.id_categoria = categoria.id_categoria
    WHERE carro_productos_extra.rut_cliente = ". $rut_cliente;
    $resultCurso = $conn->query($sqlCurso);

    // Variable para el total
    $total = 0; 

    // Variable para mostrar cuántos productos hay en el carro de compras
    $totalProductos = $result->num_rows + $resultCurso->num_rows;

    // TARJETA CON SALDO DE 100.000 PESOS, PARA HACER COMPRA, VALIDANDO LOS DATOS
    // Y MOSTRANDO TODAS LAS ALERTAS 
    $nombre_tarjeta = "Camila Barrera";
    $num_tarjeta = "1234 5678 8083 8083";
    $fechaexp_tarjeta = "11/31";
    $CVV = "123";
    $saldo = 100000;

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
                                            </ul>
                                        </div>

                                        <div class="tab-content">
                                            <div class="tab-pane fade show active" id="pills-bill-info" role="tabpanel" aria-labelledby="pills-bill-info-tab">
                                                <div style="margin-bottom: 30px;">
                                                    <h4 class="mb-1">Información personal</h4>
                                                    <h8 class="mb-1">Verifique que la información esté correcta </h8>
                                                    <a href="editarDatosCliente.php">
                                                        <button type="submit" class="btn btn-primary rounded-pill" style="font-size: 15px; margin-left:400px" name="buscar"><i class="ri-edit-box-line align-bottom"></i>Editar datos</button>
                                                    </a>
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
                                                                <input type="text" class="form-control" id="billinginfo-email" name="rut_cliente" placeholder="Ingrese RUT" value="<?= $usuario['rut_cliente'] ?>" readonly>
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
                                                            <input class="form-control" id="billinginfo-address" placeholder="Ingrese dirección" value="<?= $usuario['direccion'] ?>" readonly></input>
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
                                                            <a href="editarDatosCliente.php">
                                                                <button type="submit" class="btn btn-primary rounded-pill" style="font-size: 15px; margin-left:400px" name="buscar"><i class="ri-edit-box-line align-bottom"></i>Editar datos</button>
                                                            </a>
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

                                                <div class="row g-4" style="margin-top: 10px;">
                                                    <div class="col-lg-4 col-sm-6">
                                                        <div data-bs-toggle="collapse" data-bs-target="#paymentmethodCollapse" aria-expanded="true" aria-controls="paymentmethodCollapse">
                                                            <div class="form-check card-radio">
                                                                <input id="paymentMethod02" name="paymentMethod" type="radio" class="form-check-input" checked>
                                                                <label class="form-check-label" for="paymentMethod02">
                                                                    <span><img src="micolegioimg/logowebpay.png" style="width: 100px;"></span>
                                                                    <span class="fs-14 text-wrap">Webpay</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <form action="procesarCompra.php" method="post">
                                                    <div class="collapse show" id="paymentmethodCollapse">
                                                        <div class="card p-4 border shadow-none mb-0 mt-4">
                                                            <div class="row gy-3">
                                                                <div class="col-md-12">
                                                                    <label for="cc-name" class="form-label">Titular de la tarjeta</label>
                                                                    <input type="text" class="form-control" id="cc-name" name="nombre" placeholder="Ingrese el nombre">
                                                                    <small class="text-muted">Nombre completo impreso en la tarjeta</small>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <label for="cc-number" class="form-label">Número de la tarjeta</label>
                                                                    <input type="text" class="form-control" id="cc-number" name="numero" placeholder="xxxx xxxx xxxx xxxx" maxlength="19">
                                                                </div>

                                                                <!-- SCRIPT PARA QUE SOLO INGRESE NÚMEROS Y PONGA EL ESPACIO -->
                                                                <script>
                                                                    document.getElementById('cc-number').addEventListener('input', function (e) {
                                                                        let value = e.target.value.replace(/\D/g, ''); // Eliminar todos los caracteres que no sean dígitos
                                                                        let formattedValue = '';

                                                                        for (let i = 0; i < value.length; i++) {
                                                                            if (i > 0 && i % 4 === 0) {
                                                                                formattedValue += ' ';
                                                                            }
                                                                            formattedValue += value[i];
                                                                        }

                                                                        e.target.value = formattedValue;
                                                                    });
                                                                </script>

                                                                <div class="col-md-3">
                                                                    <label for="cc-expiration" class="form-label">Fecha de expiración</label>
                                                                    <input type="text" class="form-control" id="cc-expiration" name="fecha_exp" placeholder="Mes/Año" maxlength="5" oninput="FechaExp(this)">
                                                                    
                                                                    <script>
                                                                        // SCRIPT PARA COLOCAR "/" ENTRE EL MES Y EL AÑO

                                                                        function FechaExp(input) {
                                                                            // Eliminar cualquier carácter que no sea un dígito
                                                                            input.value = input.value.replace(/\D/g, '');

                                                                            // Después del segundo digito agrega el "/" 
                                                                            if (input.value.length > 2) {
                                                                                input.value = input.value.slice(0, 2) + '/' + input.value.slice(2);
                                                                            }

                                                                            // Limita a 5 carácteres el input
                                                                            if (input.value.length > 5) {
                                                                                input.value = input.value.slice(0, 5);
                                                                            }
                                                                        } 
                                                                    </script>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <label for="cc-cvv" class="form-label">CVV</label>
                                                                    <input type="text" class="form-control" id="cc-cvv" name="cvv" placeholder="xxx" maxlength="3">
                                                                </div>

                                                                    <!-- INPUTS ESCONDIDOS PARA PROCESAR LOS DATOS -->
                                                                <input type="hidden" name="precio_total" value="<?= $total_compra ?>">
                                                                <input type="hidden" name="rut_cliente" value="<?= $rut_cliente ?>">
                                                            </div>
                                                        
                                                        </div>

                                                        <div class="text-muted mt-2 fst-italic">
                                                            <i data-feather="lock" class="text-muted icon-xs"></i> Su transacción está encriptada
                                                        </div>
                                                    </div>

                                                    <div class="d-flex align-items-start gap-3 mt-4">
                                                        <button type="button" class="btn btn-light btn-label previestab" data-previous="pills-bill-address-tab"><i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>Volver</button>
                                                        <button type="submit" class="btn btn-primary btn-label right ms-auto nexttab"><i class="ri-shopping-basket-line label-icon align-middle fs-16 ms-2"></i>Completar compra</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- end tab pane -->

                                        </div>
                                        <!-- end tab content -->
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

    <?php include 'includes/footerCliente.php'; ?>
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