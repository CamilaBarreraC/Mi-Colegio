<!DOCTYPE html>
<html lang="es">

<?php include 'layouts/session.php'; ?>
<?php include 'layouts/main.php'; ?>

<?php
    include("modelo/conexion_bd.php");

    $conn = $conexion;

    $sql = "SELECT *
    FROM pedido 
    JOIN medios_de_pago ON pedido.id_medio_pago = medios_de_pago.id_medio_pago 
    JOIN cliente ON pedido.rut_cliente = cliente.rut_cliente
    JOIN detalle_pedido ON pedido.id_pedido = detalle_pedido.id_pedido
    JOIN lista_2 ON lista_2.id_lista_2 = detalle_pedido.id_lista_2";
    $result = $conn->query($sql);

    $estado = "";

// Agrega WHERE según los valores de los selects con filtros
if (empty($_POST['xestado'])) {
    $sql = "SELECT *
    FROM pedido 
    JOIN medios_de_pago ON pedido.id_medio_pago = medios_de_pago.id_medio_pago 
    JOIN cliente ON pedido.rut_cliente = cliente.rut_cliente
    JOIN detalle_pedido ON pedido.id_pedido = detalle_pedido.id_pedido
    JOIN lista_2 ON lista_2.id_lista_2 = detalle_pedido.id_lista_2";
} else {
    $estado = $_POST['xestado'];
    $sql .= " WHERE pedido.estado = '$estado' ORDER BY fecha";
}

$result = $conn->query($sql);
    
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

<!-- GESTIÓN DE PEDIDOS, INCOMPLETA -->

<body>
    <!-- Agrega el sidebar y topbar -->
    <?php include 'includes/sidebar.php'; ?>
    <?php include 'includes/topbar.php'; ?>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <?php includeFileWithVariables('layouts/page-title.php', array('pagetitle' => 'Tables', 'title' => 'Pedidos')); ?>

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">                         
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1" style="font-size: 35px;">Pedidos</h4>
                                    
                                </div><!-- end card header -->
                                <div class="card-body">

                                    <div class="live-preview" style="margin-top: 35px;">
                                        <div class="table-responsive table-card">
                                        <form class="d-flex flex-row align-items-center" method="post">
                                                            <select name="xestado" class="form-select me-2">
                                                                <option value="">Seleccione Estado</option>
                                                                <option value="Pendiente">Pendiente</option>
                                                                <option value="Finalizado">Finalizado</option>
                                                                
                                                            </select>
                                                            <button type="submit" class="btn btn-primary rounded-pill"
                                                                style="font-size: 15px;" name="buscar"><i
                                                                    class="ri-equalizer-fill me-2 align-bottom"></i>Filtrar</button>
                                                        </form>
                                                        <a href="Pedidos.php" class="link-secondary ms-3">Limpiar
                                                            filtros</a>
                                            <table class="table align-middle table-nowrap table-striped-columns mb-0" >
                                                
                                                <thead class="table-light">
                                                    <tr>
                                                        <th scope="col" style="width: 46px;">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="" id="cardtableCheck">
                                                                <label class="form-check-label" for="cardtableCheck"></label>
                                                            </div>
                                                        </th>
                                                        <th scope="col">ID</th>
                                                        <th scope="col">Total</th>
                                                        <th scope="col">Medio de pago</th>
                                                        <th scope="col">RUT cliente</th>
                                                        <th scope="col">Nombre cliente</th>
                                                        <th scope="col">Estado</th>
                                                        <th scope="col">Fecha Pedido</th>
                                                        <th scope="col" style="width: 150px;">Opciones</th>
                                                        <th scope="col">Detalles</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php while ($row = $result->fetch_assoc()): ?>
                                                    <tr>
                                                        <td>
                                                            <div class='form-check'>
                                                                <input class='form-check-input' type='checkbox' value='' id='cardtableCheck01'>
                                                                <label class='form-check-label' for='cardtableCheck01'></label>
                                                            </div>
                                                        </td>
                                                        <td><a href='#' class='fw-medium'><?=  $row['id_pedido'] ?></a></td>
                                                        <td> $<?= $row['precio_total'] ?></td>
                                                        <td> <?= $row['nombre_medio_pago'] ?></td>
                                                        <td> <?= $row['rut_cliente'] ?></td>
                                                        <td> <?= $row['nombre_cliente'] . " " . $row['apellido_cliente'] ?></td>
                                                        <?php $color_estado = ($row['estado'] == 'Pendiente') ? 'badge bg-danger' : 'badge bg-success'; 
                                                        // Verifica el resultado de la consulta, si el resultado es 'Pendiente', 
                                                        // se guarda 'badge bg-danger, el cual es la clase del span, con el color naranjo,
                                                        // En la derecha se pone si la condición es verdadera, 
                                                        // Si es falsa, corresponderá a 'Finalizado', el cual será la la clase con span verde
                                                        // Luego se pone la variable guardada en la clase del span, con verde o naranjo ?>
                                                        <td><span class='<?= $color_estado ?>'> <?= $row['estado'] ?></span></td>
                                                        <td> <?= $row['fecha'] ?></td>
                                                        <td>
                                                            <div class='d-flex gap-2'>
                                                                <div class='edit'>
                                                                    <a href="editPedido.php?id_pedido=<?= $row['id_pedido'] ?>">
                                                                        <button type='button' class='btn btn-sm btn-info edit-item-btn'>Editar</button>
                                                                    </a>
                                                                </div>
                                                                <div class='remove'>
                                                                    <button class='btn btn-sm btn-primary remove-item-btn' data-bs-toggle='modal' data-bs-target='#deleteRecordModal' data-id_pedido="<?= $row['id_pedido'] ?>">Eliminar</button>
                                                                </div>

                                                            </div>
                                                        </td>
                                                        <td>                                                    <div class='d-flex gap-2'>
                                                        <div class='edit'>
                                                            <a
                                                                href="DetallesPedidosADM.php?id_pedido=<?= $row['id_pedido'] ?>">
                                                                <button type='button'
                                                                    class='btn btn-sm btn-info edit-item-btn' style="font-size: 15px;">Ver detalles</button>
                                                            </a>
                                                        </div>
                                                    </div></td>
                                                    </tr>
                                                    <?php endwhile; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="d-none code-view">
                                    </div>
                                </div><!-- end card-body -->
                            </div><!-- end card -->
                        </div><!-- end col -->
                    </div><!-- end row -->
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    <!-- MODAL PARA INGRESAR PEDIDO -->
    <div class="modal fade" id="exampleModalgrid" tabindex="-1" aria-labelledby="exampleModalgridLabel" aria-modal="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalgridLabel">Pedido</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="procesarPedido.php" method="post" class="tablelist-form">
                        <div class="row g-3">
                            <div class="col-xxl-6">
                                <div>
                                    <label for="choices-single-default" class="form-label" style="margin-top: 0px;">RUT Cliente</label>
                                    <select class="form-control" data-choices name="rut_cliente" id="choices-single-default" required>
                                        <option value="">Seleccione un cliente</option>
                                        <?php
                                        // Establecer conexión a la base de datos
                                        include("modelo\conexion_bd.php");

                                        // Consulta SQL para obtener las opciones
                                        $sql = "SELECT rut_cliente, nombre_cliente FROM cliente";
                                        $resultClientes = $conexion->query($sql);

                                        // Confirma si hay resultados, ordenandolos por id 
                                        // Si no hay datos, muestra la opción de no hay registros
                                        if ($result->num_rows > 0){
                                            while($row = $resultClientes->fetch_assoc()) {
                                                echo "<option value='" . $row["rut_cliente"] . "'> RUT de: " . $row["nombre_cliente"] . " " . $row["rut_cliente"] . "</option>";
                                            }
                                        }else{
                                            echo "<option value=''>No hay registros de RUT</option>";
                                        }

                                        $conexion->close();
                                        ?>
                                    </select>
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <div>
                                    <label for="choices-single-default" class="form-label" style="margin-top: 0px;">Listas</label>
                                    <select class="form-control" data-choices name="id_lista_2" id="choices-single-default" required>
                                        <option value="">Seleccione una lista</option>
                                        <?php
                                        // Establecer conexión a la base de datos
                                        include("modelo\conexion_bd.php");

                                        // Consulta SQL para obtener las opciones
                                        $sql = "SELECT id_lista_2, rut_cliente FROM lista_2";
                                        $resultPagos = $conexion->query($sql);

                                        // Confirma si hay resultados, ordenandolos por id 
                                        // Si no hay datos, muestra la opción de no hay registros
                                        if ($result->num_rows > 0){
                                            while($row = $resultPagos->fetch_assoc()) {
                                                echo "<option value='" . $row["id_lista_2"] . "'> Lista de RUT: " . $row["rut_cliente"] . "</option>";
                                            }
                                        }else{
                                            echo "<option value=''>No hay registros de listas</option>";
                                        }

                                        $conexion->close();
                                        ?>
                                    </select>
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <div>
                                    <label for="precio_total" class="form-label">Precio total</label>
                                    <input type="text" class="form-control" id="precio_total" name="precio_total" value="" placeholder="Precio total">
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <div>
                                    <label for="choices-single-default" class="form-label" style="margin-top: 0px;">Medio de pago</label>
                                    <select class="form-control" data-choices name="id_medio_pago" id="choices-single-default" required>
                                        <option value="">Medio de pago</option>
                                        <?php
                                        // Establecer conexión a la base de datos
                                        include("modelo\conexion_bd.php");

                                        // Consulta SQL para obtener las opciones
                                        $sql = "SELECT id_medio_pago, nombre_medio_pago FROM medios_de_pago";
                                        $resultPagos = $conexion->query($sql);

                                        // Confirma si hay resultados, ordenandolos por id 
                                        // Si no hay datos, muestra la opción de no hay registros
                                        if ($result->num_rows > 0){
                                            while($row = $resultPagos->fetch_assoc()) {
                                                echo "<option value='" . $row["id_medio_pago"] . "'>" . $row["nombre_medio_pago"] . "</option>";
                                            }
                                        }else{
                                            echo "<option value=''>No hay registros de medios de pago</option>";
                                        }

                                        $conexion->close();
                                        ?>
                                    </select>
                                </div>
                            </div><!--end col-->
                            <div class="col-lg-12">
                                <label for="genderInput" class="form-label">Estado</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="estado" id="inlineRadio1" value="Finalizado">
                                        <label class="form-check-label" for="inlineRadio1">Finalizado</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="estado" id="inlineRadio2" value="Pendiente">
                                        <label class="form-check-label" for="inlineRadio2">Pendiente</label>
                                    </div>
                                </div>
                            </div><!--end col-->
                            <div class="col-lg-12">
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Ingresar</button>
                                </div>
                            </div><!--end col-->
                        </div><!--end row-->
                    </form>
                </div>
            </div>
        </div>
    </div> <!-- FINAL MODAL AÑADIR -->

    <!-- Modal para eliminar -->
    <div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btn-close"></button>
                </div>
                <div class="modal-body">
                    <div class="mt-2 text-center">
                        <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                        <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                            <h4>Eliminar pedido</h4>
                            <p class="text-muted mx-4 mb-0">¿Desea eliminar este pedido?</p>
                        </div>
                    </div>
                    <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                        <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Volver</button>
                                        
                        <button class="btn w-sm btn-danger" id="delete-record">Sí, eliminar</button>                                 
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end modal -->

    <!-- SCRIPT PARA EXTRAER EL ID_PEDIDO Y PASARLO EN URL A ELIMINARPEDIDO.PHP -->
    <script>
        // Agregar evento de clic a los botones "Eliminar", mediante la clase del botón
        document.querySelectorAll('.btn').forEach(button => {
            button.addEventListener('click', function() {
                // Obtener el valor de id_pedido del atributo data-id_pedido
                var id_pedido = this.getAttribute('data-id_pedido');
                // Guardar el valor de id_pedido en una variable
                var pedido_eliminar = id_pedido;

                // Mostrar el modal de eliminación
                document.getElementById('deleteRecordModal').style.display = 'none';

                // Después de confirmar la eliminación, oculta el modal y envía los datos a eliminar.php
                document.getElementById('delete-record').addEventListener('click', function() {
                                    
                    document.getElementById('deleteRecordModal').style.display = 'none';
                    // Redirige a la página de eliminarPedido.php, junto con el parámetro de ID de la tabla para eliminar
                    window.location.href = 'eliminarPedido.php?id_pedido=' + pedido_eliminar;
                });
            });
        });
    </script>

    <?php include 'layouts/vendor-scripts.php'; ?>

    <!-- prismjs plugin -->
    <script src="assets/libs/prismjs/prism.js"></script>

    <!-- App js -->
    <script src="assets/js/app.js"></script>
</body>

</html>