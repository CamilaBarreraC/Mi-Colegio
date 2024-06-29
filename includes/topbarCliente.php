<style>
    @import url(https://fonts.googleapis.com/css2?family=Barlow:wght@100&display=swap);
    @import url(https://fonts.googleapis.com/css2?family=Barlow:wght@700&display=swap);
    @import url(https://fonts.googleapis.com/css2?family=Barlow:ital,wght@1,500&display=swap);
    @import url(https://fonts.googleapis.com/css2?family=Aleo&display=swap);
    @import url(https://fonts.googleapis.com/css2?family=Barlow:ital,wght@1,600&display=swap);

    .logo1:hover{
        color: fuchsia;
    }
</style>

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
    WHERE carro_compras.rut_cliente = ". $rut_cliente;
    $resultProd = $conn->query($sql);

    $sqlExtras = "SELECT *
    FROM carro_productos_extra 
    JOIN cliente ON carro_productos_extra.rut_cliente = cliente.rut_cliente
    JOIN productos ON carro_productos_extra.id_producto = productos.id_producto
    WHERE carro_productos_extra.rut_cliente = ". $rut_cliente;
    $resultExtras = $conn->query($sqlExtras);

    // Variable para el total
    $subtotal = 0;

    $total_compra = 0;

    // Variable para mostrar cuántos productos hay en el carro de compras
    $totalProductos = $resultProd->num_rows + $resultExtras->num_rows;

?>

<header id="page-topbar" style="background-color: #5c46ea">
    <div class="layout-width" style="background-color: #5c46ea">
        <div class="navbar-header" style="background-color: #5c46ea">
            <div class="d-flex" style="background-color: #5c46ea;">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="PagCliente.php" class="logo logo-light">        
                        <span class="logo-lg">
                            <img src="micolegioImg/logo_sidebar.png" alt="" height="65">           
                        </span>
                    </a>
                </div>
                <h1 class="logo1" style="align-items: center;text-align:center; color:rgba(230, 237, 252, 1);font-family: Barlow; font-style: italic;font-weight: 1000; font-size: 40px; margin-top: 10px">Mi Colegio</h1>

                <!-- NO BORRAR -->
                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>      
            </div>
                

            <div class="d-flex align-items-center">

                <div class="dropdown topbar-head-dropdown ms-1 header-item">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" id="page-header-cart-dropdown" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
                        <i class='bx bx-shopping-bag fs-22'></i>
                        <span class="position-absolute topbar-badge cartitem-badge fs-10 translate-middle badge rounded-pill bg-info"><?php echo $totalProductos; ?></span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-xl dropdown-menu-end p-0 dropdown-menu-cart" aria-labelledby="page-header-cart-dropdown">
                        <div class="p-3 border-top-0 border-start-0 border-end-0 border-dashed border">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="m-0 fs-16 fw-semibold"> Carrito de compras</h6>
                                </div>
                                <div class="col-auto">
                                    <span class="badge bg-warning-subtle text-warning fs-13"><span class="cartitem-badge"><?php echo "$totalProductos"; ?></span>
                                        productos</span>
                                </div>
                            </div>
                        </div>

                        <?php if($totalProductos > 0) : ?>
                        <div data-simplebar style="max-height: 300px;">
                            <div class="p-2">
                                    
                                <?php if ($resultProd->num_rows > 0) : ?>

                                    <?php
                                        //Definir variables vacías fuera del while para mostrar el curso y colegio por los productos de una lista
                                        $NomCurso = null;
                                        $NomColegio = null;
                                    ?>
                                    
                                    <?php while($row = $resultProd->fetch_assoc()) : ?>
                                        <?php //Validador para que no se repitan los nombres de curso y colegio
                                        // que se muestran en el carro

                                        if ($row['nombre_curso'] !== $NomCurso || $row['nombre_de_colegio'] !== $NomColegio) : ?>
                                            <div class="px-2" style="margin-top: 15px;">
                                                <h5 class="m-0 fw-normal"><?php echo $row['nombre_curso']; ?>  Colegio: <?php echo $row['nombre_de_colegio']; ?></h5>
                                            </div>
                                            <?php
                                                // Actualiza las variables $prevCurso y $prevColegio con los nombres actuales del while
                                                $NomCurso = $row['nombre_curso'];
                                                $NomColegio = $row['nombre_de_colegio'];
                                            ?>
                                        <?php endif; ?>

                                        <?php
                                            // Calcular el subtotal de los productos (cantidad * precio)
                                            $subtotal = $row['cantidad'] * $row['precio'];
                                            $total_compra += $subtotal;
                                        ?>

                                        <div class="d-block dropdown-item dropdown-item-cart text-wrap px-3 py-2">
                                            <div class="d-flex align-items-center">
                                                <img src="<?php echo $row['dir']; ?>" class="me-3 rounded-circle avatar-sm p-2 bg-light" alt="user-pic">
                                                <div class="flex-grow-1">
                                                    <h6 class="mt-0 mb-1 fs-14">
                                                        <a href="#" class="text-reset"><?php echo $row['nombre_producto']; ?></a>
                                                    </h6>
                                                    <p class="mb-0 fs-12 text-muted">
                                                        Cantidad: <span><?php echo $row['cantidad']; ?></span>
                                                    </p>
                                                </div>
                                                <div class="px-2">
                                                    <div>Subtotal : $<span class="product-line-price"><?= $subtotal ?></span></div>
                                                </div>
                                                <div class="ps-2">
                                                </div>
                                            </div>
                                        </div>

                                    <?php endwhile; ?>
                                    <hr>

                                <?php endif; ?>

                                <?php if ($resultExtras->num_rows > 0) : ?>
                                    <div class="px-2" style="margin-top: 20px;">
                                        <h5 class="m-0 fw-normal" style="font-size: 25px;">Extras :</h5>
                                    </div>

                                    <?php while($rowExtras = $resultExtras->fetch_assoc()) : ?>

                                        <?php
                                            // Calcular el subtotal de los productos (cantidad * precio)
                                            $subtotal = $rowExtras['cantidad'] * $rowExtras['precio'];

                                            $total_compra += $subtotal;
                                        ?>
                                    
                                        <div class="d-block dropdown-item dropdown-item-cart text-wrap px-3 py-2">
                                            <div class="d-flex align-items-center">
                                                <img src="<?php echo $rowExtras['dir']; ?>" class="me-3 rounded-circle avatar-sm p-2 bg-light" alt="user-pic">
                                                <div class="flex-grow-1">
                                                    <h6 class="mt-0 mb-1 fs-14">
                                                        <a href="#" class="text-reset"><?php echo $rowExtras['nombre_producto']; ?></a>
                                                    </h6>
                                                    <p class="mb-0 fs-12 text-muted">
                                                        Cantidad: <span><?php echo $rowExtras['cantidad']; ?></span>
                                                    </p>
                                                </div>
                                                <div class="px-2">
                                                    <div>Subtotal : $<span class="product-line-price"><?= $subtotal ?></span></div>
                                                </div>
                                                <div class="ps-2">
                                                </div>
                                            </div>
                                        </div>

                                    <?php endwhile; ?>
                                
                                <?php endif; ?>
                                                               
                            </div>
                        </div>

                        <?php else : ?>
                            <div class="text-center empty-cart" id="empty-cart">
                                <div class="avatar-md mx-auto my-3">
                                    <div class="avatar-title bg-info-subtle text-info fs-36 rounded-circle">
                                        <i class='bx bx-cart'></i>
                                    </div>
                                </div>
                                <h5 class="mb-3">¡Su carrito está vacío!</h5>
                                <a href="ListasColegioPagCliente.php" class="btn btn-success w-md mb-3">Ver listas</a>
                            </div>
                        <?php endif; ?>
                        
                        <div class="p-3 border-bottom-0 border-start-0 border-end-0 border-dashed border" id="checkout-elem">
                            <div class="d-flex justify-content-between align-items-center pb-3">
                                
                            </div>

                            <a href="DetallesCarro.php" class="btn btn-success text-center w-100">
                                Ver detalles
                            </a>
                        </div>
                    </div>
                </div>

                <div class="dropdown ms-sm-3 header-item topbar-user" style="background-color: rgba(105, 94, 239, 1); width:140px;">
                    <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                        <span class="d-flex align-items-center" >
                            <!-- Datos del usuario que inicia sesión, imagen de perfil y nombre del usuario -->
                            <img class="rounded-circle header-profile-user" src="micolegioImg/logo_sidebar.png" alt="Header Avatar">
                            <span class="text-start ms-xl-2" >                              
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text" style="color:white"> <?php echo $_SESSION['nombre_cliente']; ?> </span>
                                <span class="d-none d-xl-block ms-1 fs-12 user-name-sub-text"><?php  ?></span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" >
                        <h6 class="dropdown-header">¡Bienvenid@ <?php echo $_SESSION['nombre_cliente']; ?>!</h6>
                        <a class="dropdown-item" href="DatosUsuario.php"><i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Mis datos</span></a>
                        <a class="dropdown-item" href="PedidosUsuario.php"><i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Mis pedidos</span></a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href=#><i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-key="t-logout" onclick="confirmCerrar()">Cerrar sesión</span></a>
                        <!-- botón cerrar sesión -->

                        <!-- JavaScript para mostrar la confirmación -->
                        <script>
                            function confirmCerrar() {
                                // Mostrar la confirmación con SweetAlert
                                Swal.fire({
                                    title: "Cerrar sesión",
                                    text: "¿Desea cerrar sesión?",
                                    icon: "question",
                                    showCancelButton: true,
                                    confirmButtonColor: "#3085d6",
                                    cancelButtonColor: "#d33",
                                    confirmButtonText: "Sí, cerrar sesión",
                                    cancelButtonText: "Cancelar"
                                }).then((result) => {

                                    if (result.isConfirmed) {
                                        // Redireccionar a la página de iniciar sesión
                                        window.location.href = "index.php";
                                        session_unset();
                                        session_destroy();                    
                                    }
                                });
                            }
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>

</header>

<!-- removeNotificationModal -->
<div id="removeNotificationModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="NotificationModalbtn-close"></button>
            </div>
            <div class="modal-body">
                <div class="mt-2 text-center">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                        <h4>Are you sure ?</h4>
                        <p class="text-muted mx-4 mb-0">Are you sure you want to remove this Notification ?</p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn w-sm btn-danger" id="delete-notification">Yes, Delete It!</button>
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
