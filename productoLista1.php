<!DOCTYPE html>
<html lang="es">

<?php include 'layouts/session.php'; ?>
<?php include 'layouts/main.php'; ?>

<?php

    // Obtener el ID del colegio desde la URL
    $id_lista_1 = $_GET['id_lista_1'];

    // Llamar al controlador para obtener los datos del pedido
    require_once('controlador/crud_lista1productos/controlador_lista1productos.php');
    $controlador = new ControladorProductoLista1();
    $lista1productos = $controlador->showProductoLista1($id_lista_1);

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Colegio</title>
    <link rel="icon" type="icon" href="micolegio img/logo.png"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php includeFileWithVariables('layouts/title-meta.php', array('title' => 'Datatables')); ?>

    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">

    <?php include 'layouts/head-css.php'; ?>

</head>

<style>
    @import url(https://fonts.googleapis.com/css2?family=Barlow:wght@100&display=swap);
    @import url(https://fonts.googleapis.com/css2?family=Barlow:wght@700&display=swap);
    @import url(https://fonts.googleapis.com/css2?family=Barlow:ital,wght@1,500&display=swap);
    @import url(https://fonts.googleapis.com/css2?family=Aleo&display=swap);
    @import url(https://fonts.googleapis.com/css2?family=Barlow:ital,wght@1,600&display=swap);

    .inicio{
        background-color: rgb(226, 233, 254);
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

                    <?php includeFileWithVariables('layouts/page-title.php', array('pagetitle' => 'Tables', 'title' => 'Lista 1')); ?>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 id="exampleModalgridLabel" style="color: rgba(105, 94, 239, 1);font-size:30px; margin-bottom: 20px">ID Lista: <?= $id_lista_1 ?></h5>
                                    <div class="col-lg-12">
                                        <div class="hstack gap-2 justify-content-end">
                                            <a href="Listas1.php">
                                                <button type="button" class="btn btn-light">Volver</button>
                                            </a>
                                        </div>
                                    </div><!--end col-->
                                </div>

                                <div class="card-body">
                                    <button type='button' class='btn btn-info add-btn' data-bs-toggle='modal' id="create-btn" data-bs-target='#exampleModalgrid' style="background-color:blueviolet;margin-bottom: 20px" ><i class="ri-add-line align-bottom me-1"></i>Añadir producto a la lista</button>

                                    <table id="alternative-pagination" class="table nowrap dt-responsive align-middle table-hover table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>ID producto lista 1</th>
                                                <th>Nombre producto</th>
                                                <th>Cantidad</th>
                                                <th>Nombre lista 1</th>
                                                <th>Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        <!-- Verificar si se encontraron datos -->

                                        <?php if ($lista1productos !== false && is_array($lista1productos)) : ?>
                                            <?php foreach ($lista1productos as $producto) : 
                                                $id_lista_1_productos = $producto['id_lista_1_productos'];
                                                $nombre_producto = $producto['nombre_producto'];
                                                $cantidad = $producto['cantidad'];
                                                $nombre_l1 = $producto['nombre_l1']; ?>

                                            <tr>
                                                <td style="color:blue"> <?= $id_lista_1_productos ?></td>
                                                <td> <?= $nombre_producto ?></td>                              
                                                <td> <?= $cantidad ?></td>
                                                <td> <?= $nombre_l1 ?></td>

                                                <td>
                                                    <div class='d-flex gap-2'>
                                                        <div class='edit'>
                                                            <a href="editLista1producto.php?id_lista_1_productos=<?=$id_lista_1_productos?>">
                                                                <button type='button' class='btn btn-sm btn-info edit-item-btn'>Editar</button>
                                                            </a>
                                                        </div>
                                                        <div class='remove'>
                                                            <button class='btn btn-sm btn-primary remove-item-btn' data-bs-toggle='modal' data-bs-target='#deleteRecordModal' data-id_producto="<?= $id_lista_1_productos ?>" data-id_lista_1="<?= $id_lista_1 ?>">Eliminar</button>
                                                        </div>
                                                    </div>
                                                </td>                          
                                            </tr>
                                            
                                            <?php endforeach; ?>
                                           <?php endif; ?>
                                            
                                        </tbody>
                                    </table>
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- OPCIONES DE LISTA 1 -->

    <!-- MODAL PARA INGRESAR PRODUCTO A LISTA 1 -->
    <div class="modal fade" id="exampleModalgrid" tabindex="-1" aria-labelledby="exampleModalgridLabel" aria-modal="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalgridLabel" style="font-size: 30px;">Añadir producto a lista <?= $id_lista_1 ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="procesarLista1Productos.php" method="post" class="tablelist-form">
                        <div class="row g-3">
                            <div class="col-xxl-6" style="display: none;">
                                <div style="display: none;">
                                    <label for="id_lista_1" class="form-label" style="margin-top: 0px; display:none">ID Lista</label>
                                    <input type="text" class="form-control" id="id_lista_1" name="id_lista_1" value="" placeholder="ID lista 1" style="display: none;" >
                                </div>
                            </div><!--end col-->
                            
                            <div class="col-xxl-6">
                                <div>
                                    <label for="id_producto" class="form-label">Producto</label>
                                    <select class="form-control" data-choices name="id_producto" id="id_producto" required>
                                        <option value="">Seleccione producto</option>
                                        <?php
                                            // Establecer conexión a la base de datos
                                            include("modelo\conexion_bd.php");

                                            // Consulta SQL para obtener las opciones
                                            $sql = "SELECT id_producto, nombre_producto FROM productos";
                                            $resultColegios = $conexion->query($sql);

                                            // Confirma si hay resultados, ordenandolos por id 
                                            // Si no hay datos, muestra la opción de no hay registros
                                            if ($resultColegios->num_rows > 0){
                                                while($row = $resultColegios->fetch_assoc()) {
                                                    echo "<option value='" . $row["id_producto"] . "'>" . $row["nombre_producto"] . "</option>";
                                                }
                                            }else{
                                                echo "<option value=''>No hay registros de colegios</option>";
                                            }
                                        $conexion->close();
                                        ?>
                                    </select>
                                    
                                </div>
                            </div><!--end col-->

                            <div class="col-xxl-6">
                                <div>
                                    <label for="cantidad" class="form-label">Cantidad</label>
                                    <input type="number" class="form-control" id="cantidad" name="cantidad" value="" placeholder="Cantidad">
                                </div>
                            </div><!--end col-->

                            <div class="col-xxl-6">
                                <div>
                                    <label for="id_lista_1" class="form-label">ID lista</label>
                                    <input type="text" class="form-control" id="id_lista_1" name="id_lista_1" value="<?= $id_lista_1 ?>" readonly>
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

                    <script src="js/peticionesCurso.js"></script>

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
                            <h4>Eliminar producto de la lista</h4>
                            <p class="text-muted mx-4 mb-0">¿Desea eliminar este producto de la lista?</p>
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

    <!-- SCRIPT PARA EXTRAER EL ID Y PASARLO EN URL A ELIMINAR.PHP -->
    <script>
        // Agregar evento de clic a los botones "Eliminar", mediante la clase del botón
        document.querySelectorAll('.btn').forEach(button => {
            button.addEventListener('click', function() {
                // Obtener el valor de id_lista_1_productos del atributo data-id_producto
                var id_lista_1_productos = this.getAttribute('data-id_producto');
                // Obtener el valor de id_lista1 del atributo data-id_lista1
                var id_lista_1 = this.getAttribute('data-id_lista_1');

                // Mostrar el modal de eliminación
                document.getElementById('deleteRecordModal').style.display = 'none';

                // Después de confirmar la eliminación, oculta el modal y envía los datos a eliminarLista1Productos.php
                document.getElementById('delete-record').addEventListener('click', function() {
                                    
                    document.getElementById('deleteRecordModal').style.display = 'none';
                    // Redirige a la página de eliminarLista1Productos.php, junto con los parámetros de ID
                    window.location.href = 'eliminarLista1Productos.php?id_lista_1_productos=' + id_lista_1_productos + '&id_lista_1=' + id_lista_1;
                });
            });
        });
    </script>

    <?php include 'layouts/vendor-scripts.php'; ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!--datatable js-->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <script src="assets/js/pages/datatables.init.js"></script>
    <!-- App js -->
    <script src="assets/js/app.js"></script>
</body>
</html>