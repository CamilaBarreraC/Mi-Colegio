<!DOCTYPE html>
<html lang="es">

<?php include 'layouts/session.php'; ?>
<?php include 'layouts/main.php'; ?>

<?php
    include("modelo/conexion_bd.php");

    $conn = $conexion;

    $sql = "SELECT id_producto, nombre_producto, productos.id_categoria, precio, nombre_categoria, dir
    FROM productos 
    JOIN categoria ON categoria.id_categoria = productos.id_categoria;";
    $result = $conn->query($sql);

    $sqlCategoria = "SELECT categoria.id_categoria, nombre_categoria 
    FROM categoria;";
    $resultCategoria = $conn->query($sqlCategoria);
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

                    <?php includeFileWithVariables('layouts/page-title.php', array('pagetitle' => 'Tables', 'title' => 'Productos')); ?>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0" style="font-size: 35px;">Productos</h5>
                                </div>
                                <div class="card-body">
                                    <button type='button' class='btn btn-info add-btn' data-bs-toggle='modal' id="create-btn" data-bs-target='#exampleModalgrid' style="background-color:blueviolet;margin-bottom: 20px" ><i class="ri-add-line align-bottom me-1"></i>Añadir producto</button>

                                    <table id="alternative-pagination" class="table nowrap dt-responsive align-middle table-hover table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Foto</th>
                                                <th>ID producto</th>
                                                <th>Nombre producto</th>
                                                <th>Categoría</th>
                                                <th>Precio</th>
                                                <th>Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($row = $result->fetch_assoc()): ?>
                                            <tr>
                                                <td> <img src="<?= $row['dir'] ?> " width="100px"> </td>  
                                                <td style="color:blue"> <?=  $row['id_producto'] ?></td>
                                                <td> <?= $row['nombre_producto'] ?></td>                              
                                                <td> <?= $row['nombre_categoria'] ?></td>
                                                <td> <?= $row['precio'] ?></td>
                                                
                                                <td>
                                                    <div class='d-flex gap-2'>
                                                        <div class='edit'>
                                                            <a href="editProducto.php?id_producto=<?= $row['id_producto'] ?>">
                                                                <button type='button' class='btn btn-sm btn-info edit-item-btn'>Editar</button>
                                                            </a>
                                                        </div>
                                                        <div class='remove'>
                                                            <button class='btn btn-sm btn-primary remove-item-btn' data-bs-toggle='modal' data-bs-target='#deleteRecordModal' data-id_producto="<?= $row['id_producto'] ?>">Eliminar</button>
                                                        </div>
                                                    </div>
                                                </td>                          
                                            </tr>
                                            <?php endwhile; ?>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0" style="font-size: 35px;">Categorías</h5>
                                </div>
                                <div class="card-body">

                                <button type='button' class='btn btn-info add-btn' data-bs-toggle='modal' id="create-btn" data-bs-target='#ModalgridCurso' style="background-color:darkslateblue;margin-bottom: 20px" ><i class="ri-add-line align-bottom me-1"></i>Añadir categoría</button>

                                    <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                        <thead>
                                            
                                            <tr>
                                                <th scope="col" style="width: 10px;">
                                                    <div class="form-check">
                                                        <input class="form-check-input fs-15" type="checkbox" id="checkAll" value="option" style="display: none;"> ID categoría
                                                    </div>
                                                </th>
                                                <th>Nombre categoría</th>
                                                <th>Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($rowCategoria = $resultCategoria->fetch_assoc()): ?>
                                            <tr>
                                                <td style="color:blueviolet"> <?=  $rowCategoria['id_categoria'] ?></td>
                                                <td> <?= $rowCategoria['nombre_categoria'] ?></td>                              
                                               
                                                <td>
                                                    <div class='d-flex gap-2'>
                                                        <div class='edit'>
                                                            <a href="editCategoria.php?id_categoria=<?= $rowCategoria['id_categoria'] ?>">
                                                                <button type='button' class='btn btn-sm btn-info edit-item-btn'>Editar</button>
                                                            </a>
                                                        </div>
                                                        <div class='remove'>
                                                            <button class='btnCurso btn-sm btn-primary remove-item-btn' data-bs-toggle='modal' data-bs-target='#deleteCurso' style="background-color:blueviolet;color:white; border-radius:4px; border-color:blueviolet" data-id_categoria="<?= $rowCategoria['id_categoria'] ?>">Eliminar</button>
                                                        </div>
                                                    </div>
                                                </td>                          
                                            </tr>
                                            <?php endwhile; ?>
                                            
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

    <!-- OPCIONES DE PRODUCTOS -->

    <!-- MODAL PARA INGRESAR PRODUCTO -->
    <div class="modal fade" id="exampleModalgrid" tabindex="-1" aria-labelledby="exampleModalgridLabel" aria-modal="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalgridLabel" style="font-size: 30px;">Añadir producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="procesarProducto.php" method="post" enctype="multipart/form-data" class="tablelist-form">
                        <div class="row g-3">
                            <div class="col-xxl-6" style="display: none;">
                                <div style="display: none;">
                                    <label for="id_producto" class="form-label" style="margin-top: 0px; display:none">ID producto</label>
                                    <input type="text" class="form-control" id="id_producto" name="id_producto" value="" placeholder="ID producto" style="display: none;" >
                                </div>
                            </div><!--end col-->

                            <div class="col-xxl-6">
                                <div>
                                    <label for="nombre_producto" class="form-label" style="margin-top: 0px;">Nombre producto</label>
                                    <input type="text" class="form-control" id="nombre_producto" name="nombre_producto" value="" placeholder="Nombre producto">
                                </div>
                            </div><!--end col-->

                            <div class="col-xxl-6">
                                <div>
                                    <label for="choices-single-default" class="form-label">Categoría</label>
                                    <select class="form-control" data-choices name="id_categoria" id="choices-single-default" required>
                                        <option value="">Categoría</option>
                                        <?php
                                        // Establecer conexión a la base de datos
                                        include("modelo\conexion_bd.php");

                                        // Consulta SQL para obtener las opciones
                                        $sql = "SELECT id_categoria, nombre_categoria FROM categoria";
                                        $resultComunas = $conexion->query($sql);

                                        // Confirma si hay resultados, ordenandolos por id 
                                        // Si no hay datos, muestra la opción de no hay registros
                                        if ($result->num_rows > 0){
                                            while($row = $resultComunas->fetch_assoc()) {
                                                echo "<option value='" . $row["id_categoria"] . "'>" . $row["nombre_categoria"] . "</option>";
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
                                    <label for="precio" class="form-label">Precio</label>
                                    <input type='number' class="form-control" id="precio" name="precio" value="" placeholder="Precio" required>
                                </div>
                            </div><!--end col-->

                            <div class="col-xxl-6">
                                <div>
                                <label for="formFile" class="form-label">Imagen</label>
                                <input class="form-control" type="file" id="imagen" name="imagen">
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
                            <h4>Eliminar producto</h4>
                            <p class="text-muted mx-4 mb-0">¿Desea eliminar este producto?</p>
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
                // Obtener el valor de id del atributo data-id_colegio
                var id_producto = this.getAttribute('data-id_producto');
                // Guardar el valor de id en una variable
                var producto_eliminar = id_producto;

                // Mostrar el modal de eliminación
                document.getElementById('deleteRecordModal').style.display = 'none';

                // Después de confirmar la eliminación, oculta el modal y envía los datos a eliminarColegio.php
                document.getElementById('delete-record').addEventListener('click', function() {
                                    
                    document.getElementById('deleteRecordModal').style.display = 'none';
                    // Redirige a la página de eliminarColegio.php, junto con el parámetro de ID de la tabla para eliminar
                    window.location.href = 'eliminarProducto.php?id_producto=' + producto_eliminar;
                });
            });
        });
    </script>

    <!-- OPCIONES DE CATEGORÍA -->

    <!-- MODAL PARA INGRESAR CURSO -->
    <div class="modal fade" id="ModalgridCurso" tabindex="-1" aria-labelledby="exampleModalgridLabel" aria-modal="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalgridLabel" style="font-size: 30px;">Añadir categoría</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="procesarCategoria.php" method="post" class="tablelist-form">
                        <div class="row g-3">

                            <div class="col-xxl-6">
                                <div>
                                    <label for="nombre_categoria" class="form-label">Nombre categoría</label>
                                    <input type="text" class="form-control" id="nombre_categoria" name="nombre_categoria" value="" placeholder="Nombre categoría" required>
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

    <!-- Modal para eliminar curso -->
    <div class="modal fade zoomIn" id="deleteCurso" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btn-close"></button>
                </div>
                <div class="modal-body">
                    <div class="mt-2 text-center">
                        <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                        <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                            <h4>Eliminar categoría</h4>
                            <p class="text-muted mx-4 mb-0">¿Desea eliminar esta categoría?</p>
                        </div>
                    </div>
                    <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                        <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Volver</button>
                                        
                        <button class="btn w-sm btn-danger" id="delete-recordCurso">Sí, eliminar</button>                                 
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end modal -->

    <!-- SCRIPT PARA EXTRAER EL ID Y PASARLO EN URL A ELIMINAR.PHP -->
    <script>
        // Agregar evento de clic a los botones "Eliminar", mediante la clase del botón
        document.querySelectorAll('.btnCurso').forEach(button => {
            button.addEventListener('click', function() {
                // Obtener el valor de id del atributo data-id_curso
                var id_categoria = this.getAttribute('data-id_categoria');
                // Guardar el valor de id en una variable
                var categoria_eliminar = id_categoria;

                // Mostrar el modal de eliminación
                document.getElementById('deleteCurso').style.display = 'none';

                // Después de confirmar la eliminación, oculta el modal y envía los datos a eliminarCurso.php
                document.getElementById('delete-recordCurso').addEventListener('click', function() {
                                    
                    document.getElementById('deleteCurso').style.display = 'none';
                    // Redirige a la página de eliminarCurso.php, junto con el parámetro de ID de la tabla para eliminar
                    window.location.href = 'eliminarCategoria.php?id_categoria=' + categoria_eliminar;
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