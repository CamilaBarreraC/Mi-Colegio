<!DOCTYPE html>
<html lang="es">

<?php include 'layouts/session.php'; ?>
<?php include 'layouts/main.php'; ?>

<?php

    if (isset($_GET['pedido'])) {
        $pedido = $_GET['pedido'];

        if (isset($_GET['producto'])) {
            $producto = urldecode($_GET['producto']);
        }

        // Mostrar un mensaje basado en el valor del parámetro 'pedido'
        if ($pedido == 'FaltaStock' && $producto) {
            echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>';
            echo 'a';
            echo '<script>
                    Swal.fire({
                        icon: "warning",
                        title: "Falta de stock",
                        text: "No hay suficiente stock para el producto: ' . $producto . '",
                        showConfirmButton: false
                    });
                </script>';
        }
    }

?>

<?php

    include("modelo/conexion_bd.php");

    $conn = $conexion;

    $rut_cliente = $_SESSION['rut_cliente'];

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

                <?php includeFileWithVariables('layouts/page-title.php', array('pagetitle' => 'Ecommerce', 'title' => 'Carro de compras')); ?>

                <form method="post" action="actualizarCantidades.php">
                    <div class="row mb-3">
                        <div class="col-xl-8">
                            <div class="row align-items-center gy-3 mb-3">
                                <div class="col-sm">
                                    <div>
                                        <h5 class="fs-14 mb-0">Hay <?php echo "$totalProductos"; ?> productos en su carro de compras</h5>
                                    </div>
                                </div>
                                <div class="col-sm-auto">
                                    <a href="ProductosPagCliente.php" class="link-primary text-decoration-underline">Continuar comprando</a>
                                </div>
                            </div>   

                            <?php if ($result->num_rows > 0) : ?>

                                <?php
                                    //Definir variables vacías fuera del while para mostrar el curso y colegio por los productos de una lista
                                    $NomCurso = null;
                                    $NomColegio = null;
                                ?>

                                <?php while ($row = $result->fetch_assoc()): ?>

                                    <?php //Validador para que no se repitan los nombres de curso y colegio
                                    // que se muestran en el carro

                                    if ($row['nombre_curso'] !== $NomCurso || $row['nombre_de_colegio'] !== $NomColegio) : ?>
                                        <div class="px-2" style="margin-top: 15px; margin-bottom:20px">
                                            <h5 class="m-0 fw-normal" style="font-size: 25px; color:#5c46ea">
                                                Lista de <?php echo $row['nombre_curso']; ?>  Colegio: <?php echo $row['nombre_de_colegio']; ?>
                                            </h5>
                                        </div>
                                        <?php
                                            // Actualiza las variables $prevCurso y $prevColegio con los nombres actuales del while
                                            $NomCurso = $row['nombre_curso'];
                                            $NomColegio = $row['nombre_de_colegio'];
                                        ?>
                                    <?php endif; ?>

                                    <div class="card product">
                                        <div class="card-body">
                                            <div class="row gy-3">
                                                <div class="col-sm-auto">
                                                    <div class="avatar-lg bg-light rounded p-1">
                                                        <img src="<?php echo $row['dir']; ?>" alt="" style="height: 95%; width:100%" class="img-fluid d-block">
                                                    </div>
                                                </div>
                                                <div class="col-sm">
                                                    <h5 class="fs-14 text-truncate"><a href="ecommerce-product-detail.php" class="text-body"><?php echo $row['nombre_producto']; ?></a></h5>
                                                    <ul class="list-inline text-muted">
                                                        <li class="list-inline-item">Categoría : <span class="fw-medium"><?php echo $row['nombre_categoria']; ?></span></li>                                        
                                                    </ul>

                                                    <div class="input-step">
                                                        <button type="button" class="minus">–</button>
                                                        <input type="number" class="product-quantity" name="cantidades[<?php echo $row['id_producto']; ?>]" value="<?php echo $row['cantidad']; ?>" min="1" max="<?php echo $row['stock']; ?>" readonly>
                                                        <button type="button" class="plus">+</button>
                                                    </div>
                                                </div>
                                                <div class="col-sm-auto">
                                                    <div class="text-lg-end">
                                                        <p class="text-muted mb-1">Precio:</p>
                                                        <h5 class="fs-14">$<span id="ticket_price" class="product-price"><?php echo $row['precio']; ?></span></h5>
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
                                                            <?php
                                                            // Calcular el subtotal de los productos (cantidad * precio)
                                                            $subtotal = $row['cantidad'] * $row['precio'];
                                                            // Agregar el subtotal al total
                                                            $total += $subtotal; 
                                                            ?>
                                                            <div>Subtotal : $<span class="product-line-price"><?= $subtotal ?></span></div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-auto">
                                                    <div class="d-flex align-items-center gap-2 text-muted">
                                                        <a class='btn btn-sm btn-primary remove-item-btn' data-bs-toggle='modal' data-bs-target='#removeItemModal' data-id_producto="<?= $row['id_producto'] ?>">Eliminar</a>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end card footer -->
                                    </div>
                                    <!-- end card -->

                                <?php endwhile; ?>
                                <hr>

                            <?php else : ?>
                                <div class="text-center empty-cart" id="empty-cart">
                                    <div class="avatar-md mx-auto my-3">
                                        <div class="avatar-title bg-info-subtle text-info fs-36 rounded-circle">
                                            <i class='bx bx-cart'></i>
                                        </div>
                                    </div>
                                    <h5 class="mb-3">Su carrito está vacío!</h5>
                                    <a href="ListasColegioPagCliente.php" class="btn btn-success w-md mb-3">Ver listas</a>
                                </div>
                            <?php endif; ?>

                            <?php if ($resultExtras->num_rows > 0) : ?>
                                <div class="px-2" style="margin-top: 20px; margin-bottom: 15px">
                                    <h5 class="m-0 fw-normal" style="font-size: 25px; color:blue">Extras :</h5>
                                </div>

                                <?php while ($rowCurso = $resultCurso->fetch_assoc()): ?>
                                        
                                    <div class="card product">
                                        <div class="card-body">
                                            <div class="row gy-3">
                                                <div class="col-sm-auto">
                                                    <div class="avatar-lg bg-light rounded p-1">
                                                        <img src="<?php echo $rowCurso['dir']; ?>" alt="" style="height: 95%; width:100%" class="img-fluid d-block">
                                                    </div>
                                                </div>
                                                <div class="col-sm">
                                                    <h5 class="fs-14 text-truncate"><a href="ecommerce-product-detail.php" class="text-body"><?php echo $rowCurso['nombre_producto']; ?></a></h5>
                                                    <ul class="list-inline text-muted">
                                                        <li class="list-inline-item">Categoría : <span class="fw-medium"><?php echo $rowCurso['nombre_categoria']; ?></span></li>                                        
                                                    </ul>

                                                    <div class="input-step">
                                                        <button type="button" class="minus">–</button>
                                                        <input type="number" class="product-quantity" name="cantidades_extras[<?php echo $rowCurso['id_producto']; ?>]" value="<?php echo $rowCurso['cantidad']; ?>" min="1" max="<?php echo $rowCurso['stock']; ?>" readonly>
                                                        <button type="button" class="plus">+</button>
                                                    </div>
                                                </div>
                                                <div class="col-sm-auto">
                                                    <div class="text-lg-end">
                                                        <p class="text-muted mb-1">Precio:</p>
                                                        <h5 class="fs-14">$<span id="ticket_price" class="product-price"><?php echo $rowCurso['precio']; ?></span></h5>
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
                                                            <?php
                                                            // Calcular el subtotal de los productos (cantidad * precio)
                                                            $subtotal = $rowCurso['cantidad'] * $rowCurso['precio'];
                                                            // Agregar el subtotal al total
                                                            $total += $subtotal; 
                                                            ?>
                                                            <div>Subtotal : $<span class="product-line-price"><?= $subtotal ?></span></div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-auto">
                                                    <div class="d-flex align-items-center gap-2 text-muted">
                                                        <a class='boton btn-sm btn-primary remove-item-btn' data-bs-toggle='modal' data-bs-target='#modalEliminar' data-id_producto2="<?= $rowCurso['id_producto'] ?>">Eliminar</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end card footer -->
                                    </div>
                                    <!-- end card -->

                                <?php endwhile; ?>
                            <?php endif; ?>

                            <?php if($result->num_rows > 0) : ?>
                                <div class="text-end mb-4">
                                    <button type="submit" class="btn btn-success btn-label right ms-auto"><i class="ri-arrow-right-line label-icon align-bottom fs-16 ms-2"></i> Continuar compra</button>
                                </div>
                            <?php endif; ?>
                        </div>
                        <!-- end col -->

                        <div class="col-xl-4">
                            <div class="sticky-side-div">
                                <div class="card">
                                    <div class="card-header border-bottom-dashed">
                                        <h5 class="card-title mb-0">Total de la compra</h5>
                                    </div>
                                    <div class="card-body pt-2">
                                        <div class="table-responsive">
                                            <table class="table table-borderless mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td style="font-size: 20px;">Total :</td>
                                                        <td class="text-end" id="cart-subtotal" style="font-size: 20px; color:blueviolet">$ <?= $total ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- end table-responsive -->
                                    </div>
                                </div>
                            </div>
                            <!-- end stickey -->
                        </div>
                    </div>
                    <!-- end row -->
                </form>
            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

    <!-- removeItemModal -->
    <div id="removeItemModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mt-2 text-center">
                        <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                        <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                            <h4>¿Eliminar?</h4>
                            <p class="text-muted mx-4 mb-0">¿Desea eliminar este producto del carro?</p>
                        </div>
                    </div>
                    <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                        <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Volver</button>
                        <button type="button" class="btn w-sm btn-danger" id="remove-product">Eliminar</button>
                    </div>
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- SCRIPT PARA EXTRAER EL ID Y PASARLO EN URL A ELIMINAR.PHP -->
    <script>
        // Agregar evento de clic a los botones "Eliminar", mediante la clase del botón
        document.querySelectorAll('.btn').forEach(button => {
            button.addEventListener('click', function() {
                // Obtener el valor de id del atributo data-id_colegio
                var id_producto = this.getAttribute('data-id_producto');
                // Guardar el valor de id en una variable
                var producto_eliminar = id_producto;

                // Mostrar el modal de eliminación
                document.getElementById('removeItemModal').style.display = 'none';

                // Después de confirmar la eliminación, oculta el modal y envía los datos a eliminarLista2PagCliente.php
                document.getElementById('remove-product').addEventListener('click', function() {
                                    
                    document.getElementById('removeItemModal').style.display = 'none';
                    // Redirige al procesador eliminar de la l2, junto con el parámetro de ID para eliminar
                    window.location.href = 'eliminarLista2PagCliente.php?id_producto=' + producto_eliminar;
                });
            });
        });
    </script>

    <!-- removeItemModal -->
    <div id="modalEliminar" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mt-2 text-center">
                        <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                        <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                            <h4>¿Eliminar?</h4>
                            <p class="text-muted mx-4 mb-0">¿Desea eliminar este producto del carro?</p>
                        </div>
                    </div>
                    <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                        <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Volver</button>
                        <button type="button" class="btn w-sm btn-danger" id="remove-product2">Eliminar</button>
                    </div>
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- SCRIPT PARA EXTRAER EL ID Y PASARLO EN URL A ELIMINAR.PHP -->
    <script>
        // Agregar evento de clic a los botones "Eliminar", mediante la clase del botón
        document.querySelectorAll('.boton').forEach(button => {
            button.addEventListener('click', function() {
                // Obtener el valor de id del atributo data-id_colegio
                var id_producto = this.getAttribute('data-id_producto2');
                // Guardar el valor de id en una variable
                var producto_eliminar = id_producto;

                // Mostrar el modal de eliminación
                document.getElementById('modalEliminar').style.display = 'none';

                // Después de confirmar la eliminación, oculta el modal y envía los datos a eliminarLista2PagCliente.php
                document.getElementById('remove-product2').addEventListener('click', function() {
                                    
                    document.getElementById('modalEliminar').style.display = 'none';
                    // Redirige al procesador eliminar de la l2, junto con el parámetro de ID para eliminar
                    window.location.href = 'eliminarProductoExtra.php?id_producto=' + producto_eliminar;
                });
            });
        });
    </script>

    <?php include 'includes/footerCliente.php'; ?>
    <?php include 'layouts/vendor-scripts.php'; ?>

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