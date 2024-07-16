<!DOCTYPE html>
<html lang="es">

<?php include 'layouts/session.php'; ?>
<?php include 'layouts/main.php'; ?>

<?php
    include("modelo/conexion_bd.php");

    $conn = $conexion;

    $rut_cliente = $_SESSION['rut_cliente'];
    $id_pedido = $_GET['id_pedido'];

    // CONSULTA PARA INFO DEL CLIENTE
    $sqlCliente = "SELECT rut_cliente, nombre_cliente, apellido_cliente, clave,
    email, telefono, direccion, parentesco, cliente.id_comuna, nombre_comuna, 
	nombre_region
    FROM cliente 
    JOIN comuna ON cliente.id_comuna = comuna.id_comuna 
    JOIN region ON comuna.id_region = region.id_region
    WHERE cliente.rut_cliente = ". $rut_cliente;
    $resultCliente = $conn->query($sqlCliente);

    // CONSULTA PARA RELLENAR LA BOLETA CON LA LISTA ESCOLAR
    $sql = "SELECT *
    FROM detalle_pedido
    JOIN pedido ON pedido.id_pedido = detalle_pedido.id_pedido
    JOIN lista_2 ON lista_2.id_lista_2 = detalle_pedido.id_lista_2
    JOIN l2_productos ON lista_2.id_lista_2 = l2_productos.id_lista_2 
    JOIN productos ON l2_productos.id_producto = productos.id_producto
    JOIN categoria ON categoria.id_categoria = productos.id_categoria
    JOIN curso ON lista_2.id_curso = curso.id_curso
    JOIN colegio ON curso.id_colegio = colegio.id_colegio
    JOIN cliente ON pedido.rut_cliente = cliente.rut_cliente
    WHERE pedido.id_pedido = ". $id_pedido;
    $result = $conn->query($sql);

    // CONSULTA PARA LA BOLETA CON LOS PRODUCTOS EXTRA
    $sqlCurso = "SELECT *
    FROM detalle_pedido
    JOIN pedido ON pedido.id_pedido = detalle_pedido.id_pedido
    JOIN productos_extra ON productos_extra.id_extras = detalle_pedido.id_extras
    JOIN medios_de_pago ON pedido.id_medio_pago = medios_de_pago.id_medio_pago 
    JOIN productos ON productos_extra.id_producto = productos.id_producto
    JOIN categoria ON productos.id_categoria = categoria.id_categoria
    WHERE pedido.id_pedido = ". $id_pedido;
    $resultCurso = $conn->query($sqlCurso);

    // CONSULTA PARA RELLENAR TABLA CON LOS PRODUCTOS
    $sqlLista = "SELECT *
    FROM detalle_pedido
    JOIN pedido ON pedido.id_pedido = detalle_pedido.id_pedido
    JOIN lista_2 ON lista_2.id_lista_2 = detalle_pedido.id_lista_2
    JOIN l2_productos ON lista_2.id_lista_2 = l2_productos.id_lista_2 
    JOIN productos ON l2_productos.id_producto = productos.id_producto
    JOIN categoria ON categoria.id_categoria = productos.id_categoria
    JOIN curso ON lista_2.id_curso = curso.id_curso
    JOIN colegio ON curso.id_colegio = colegio.id_colegio
    JOIN cliente ON pedido.rut_cliente = cliente.rut_cliente
    WHERE pedido.id_pedido = ". $id_pedido;
    $resultLista = $conn->query($sqlLista);

    // CONSULTA PARA RELLENAR TABLA CON PRODUCTOS EXTRA
    $sqlExt = "SELECT *
    FROM detalle_pedido
    JOIN pedido ON pedido.id_pedido = detalle_pedido.id_pedido
    JOIN productos_extra ON productos_extra.id_extras = detalle_pedido.id_extras
    JOIN medios_de_pago ON pedido.id_medio_pago = medios_de_pago.id_medio_pago 
    JOIN productos ON productos_extra.id_producto = productos.id_producto
    JOIN categoria ON productos.id_categoria = categoria.id_categoria
    WHERE pedido.id_pedido = ". $id_pedido;
    $resultExt = $conn->query($sqlExt);

    $total = 0;
    $totalBoleta = 0;
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
    .flex-container {
        display: flex;
        justify-content: center;
        align-items: center;
        /* Espacio entre los elementos */
        gap: 40px; 
    }
    .flex-item {
        max-width: 500px;
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
                <div class="text-center py-5 flex-container" >
                    <div class="flex-item">
                        <div class="mb-4">
                            <lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop" colors="primary:#695eef,secondary:#73dce9" style="width:120px;height:120px"></lord-icon>
                        </div>
                        <h5>Gracias por su compra</h5>
                        <p class="text-muted">Aquí están los detalles de su compra.</p>

                        <h3 class="fw-semibold"><a href="PedidosUsuario.php" class="text-decoration-underline">Mis pedidos</a></h3>
                    </div>

                    <div class="card flex-item">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title mb-0"><i class="ri-currency-line align-middle me-1 text-muted"></i>Boleta electrónica</h5>
                                    <h5 class="card-title mb-0">RUT : <?= $rut_cliente ?></h5>
                                </div>
                                <div class="ms-auto">
                                    <!--Boleta Electrónica-->
                                    <form action="boletaPDF.php" method="post">
                                        <input type="hidden" name="id_pedido" value="<?= $id_pedido ?>">
                                        <button type="submit" class="btn btn-primary" name="boleta_pedido" style="background-color:red; margin-bottom: 20px;">
                                            <img style="width:20px; height:auto;" src="image/icono-pdf.png" alt="PDF Icon" class="icon">
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <table class="table table-nowrap align-middle table-borderless mb-0">
                                <thead class="table-light text-muted">
                                    <tr>
                                        <th scope="col">Producto</th>
                                        <th scope="col">Precio</th>
                                        <th scope="col">Cantidad</th>
                                        <th scope="col" class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($rowProd = $resultLista->fetch_assoc()): ?>
                                    <tr>
                                        <th><?php echo $rowProd['nombre_producto']; ?></th>
                                        <th>$<?php echo $rowProd['precio']; ?></th>
                                        <th><?php echo $rowProd['cantidad']; ?></th>
                                        <?php
                                            $subtotalBoleta = $rowProd['cantidad'] * $rowProd['precio'];
                                            $totalBoleta += $subtotalBoleta;
                                        ?>
                                        <th>$<?= $subtotalBoleta ?></th>
                                    </tr>
                                    <?php endwhile; ?>

                                    <?php while ($rowExt = $resultExt->fetch_assoc()): ?>
                                    <tr>
                                        <th><?php echo $rowExt['nombre_producto']; ?></th>
                                        <th>$<?php echo $rowExt['precio']; ?></th>
                                        <th><?php echo $rowExt['cantidad']; ?></th>
                                        <?php
                                            $subtotalBoleta = $rowExt['cantidad'] * $rowExt['precio'];
                                            $totalBoleta += $subtotalBoleta;
                                        ?>
                                        <th>$<?= $subtotalBoleta ?></th>
                                    </tr>
                                    <?php endwhile; ?>

                                    <tr>
                                        <th></th>
                                        <th style="font-size: 20px; color:blue">Total : $<?= $totalBoleta ?></th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--end card-->
                </div>

                <div class="row">
                    <div class="col-xl-3">   

                        <?php while ($row = $resultCliente->fetch_assoc()): ?>
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex">
                                        <h5 class="card-title flex-grow-1 mb-0">Datos personales</h5>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <ul class="list-unstyled mb-0 vstack gap-3">
                                        <li>   
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <img src="micolegioimg/logo_sidebar.png" alt="" class="avatar-sm rounded">
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="fs-14 mb-1"><?php echo $row['nombre_cliente'] . " " . $row['apellido_cliente']; ?></h6>
                                                    <p class="text-muted mb-0"><?php echo $row['rut_cliente']; ?></p>
                                                </div>
                                                </div>          
                                        </li>
                                        <li><i class="ri-mail-line me-2 align-middle text-muted fs-16"></i><?php echo $row['email']; ?></li>
                                        <li><i class="ri-phone-line me-2 align-middle text-muted fs-16"></i><?php echo $row['telefono']; ?></li>
                                    </ul>
                                </div>
                            </div>
                            <!--end card-->

                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0"><i class="ri-map-pin-line align-middle me-1 text-muted"></i>Dirección de entrega</h5>
                                </div>

                                <div class="card-body">
                                    <ul class="list-unstyled vstack gap-2 fs-13 mb-0">
                                        <li class="fw-medium fs-14"><?php echo $row['nombre_cliente'] . " " . $row['apellido_cliente']; ?></li>
                                        <li><?php echo $row['telefono']; ?></li>
                                        <li>Dirección : <?php echo $row['direccion']; ?></li>
                                        <li>Comuna : <?php echo $row['nombre_comuna']; ?></li>
                                        <li>Región : <?php echo $row['nombre_region']; ?></li>
                                    </ul>
                                </div>
                            </div>
                            <!--end card-->

                        <?php endwhile; ?>
                    </div>
                    <!--end col-->

                    <div class="col-xl-9">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive table-card">
                                    <table class="table table-nowrap align-middle table-borderless mb-0">
                                        <thead class="table-light text-muted">
                                            <tr>
                                                <th scope="col">Producto</th>
                                                <th scope="col">Precio</th>
                                                <th scope="col">Cantidad</th>
                                                <th scope="col" class="text-end">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($row = $result->fetch_assoc()): ?> 
                                            <tr>
                                                <td>
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0 avatar-md bg-light rounded p-1">
                                                            <img src="<?php echo $row['dir']; ?>" alt="" class="img-fluid d-block">
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h5 class="fs-15"><a href="apps-ecommerce-product-details.php" class="link-primary"><?php echo $row['nombre_producto']; ?></a></h5>
                                                            <p class="text-muted mb-0">Categoría: <span class="fw-medium"><?php echo $row['nombre_categoria']; ?></span></p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>$<?php echo $row['precio']; ?></td>
                                                <td><?php echo $row['cantidad']; ?></td>
                                                <td class="fw-medium text-end">
                                                    <?php
                                                        // Calcular el subtotal de los productos (cantidad * precio)
                                                        $subtotal = $row['cantidad'] * $row['precio'];
                                                        // Agregar el subtotal al total
                                                        $total += $subtotal; 
                                                    ?>
                                                    $<?= $subtotal ?>
                                                </td>
                                            </tr>
                                            <?php endwhile; ?>

                                            <?php while ($rowCurso = $resultCurso->fetch_assoc()): ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0 avatar-md bg-light rounded p-1">
                                                            <img src="<?php echo $rowCurso['dir']; ?>" alt="" class="img-fluid d-block">
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h5 class="fs-15"><a href="apps-ecommerce-product-details.php" class="link-primary"><?php echo $rowCurso['nombre_producto']; ?></a></h5>
                                                            <p class="text-muted mb-0">Categoría: <span class="fw-medium"><?php echo $rowCurso['nombre_categoria']; ?></span></p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>$<?php echo $rowCurso['precio']; ?></td>
                                                <td><?php echo $rowCurso['cantidad']; ?></td>
                                                <td class="fw-medium text-end">
                                                    <?php
                                                        // Calcular el subtotal de los productos (cantidad * precio)
                                                        $subtotal = $rowCurso['cantidad'] * $rowCurso['precio'];
                                                        // Agregar el subtotal al total
                                                        $total += $subtotal; 
                                                    ?>
                                                    $<?= $subtotal ?>
                                                </td>
                                            </tr>
                                            <?php endwhile; ?>

                                            <tr class="border-top border-top-dashed">
                                                <td colspan="3"></td>
                                                <td colspan="2" class="fw-medium p-0">
                                                    <table class="table table-borderless mb-0">
                                                        <tbody>
                                                            <tr class="border-top border-top-dashed">
                                                                <th scope="row" style="font-size: 20px;">Total :</th>
                                                                <th class="text-end" style="font-size: 20px;">$<?= $total ?></th>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!--end card-->
                    </div>
                    <!--end col-->
                </div>
                <!--end row-->
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