<!DOCTYPE html>
<html lang="es">

<?php include 'layouts/session.php'; ?>
<?php include 'layouts/main.php'; ?>

<?php
include("modelo/conexion_bd.php");

$conn = $conexion;

$sql = "SELECT id_colegio, nombre_de_colegio, colegio.id_comuna, direccion, nombre_comuna, nombre_region 
    FROM colegio 
    JOIN comuna ON colegio.id_comuna = comuna.id_comuna 
    JOIN region ON comuna.id_region = region.id_region;";
$result = $conn->query($sql);

$sqlCurso = "SELECT id_curso, nombre_curso, cantidad_alumnos, curso.id_colegio, colegio.nombre_de_colegio 
    FROM curso 
    JOIN colegio ON colegio.id_colegio = curso.id_colegio;";
$resultCurso = $conn->query($sqlCurso);
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Colegio</title>
    <link rel="icon" type="icon" href="micolegio img/logo.png" />
    <link rel="stylesheet" href="css\reporte_modal.css">
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

.inicio {
    background-color: rgb(226, 233, 254);
    width: 1440px;
    height: 1024px;
}
</style>

<body>
    <!-- Agrega el sidebar y topbar -->
    <?php include 'includes/sidebar2.php'; ?>
    <?php include 'includes/topbarCliente.php'; ?>

    <!-- Begin page -->
    <div id="layout-wrapper">
            <div class="page-content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0" style="font-size: 35px;">Mis pedidos</h5>
                                </div>
                                <div class="card-body">

                                    <table id="example"
                                        class="table table-bordered dt-responsive nowrap table-striped align-middle"
                                        style="width:100%">
                                        <thead>

                                            <tr>
                                                <th scope="col" style="width: 10px;">
                                                    <div class="form-check">
                                                        <input class="form-check-input fs-15" type="checkbox"
                                                            id="checkAll" value="option" style="display: none;"> ID
                                                        curso
                                                    </div>
                                                </th>
                                                <th>Nombre curso</th>
                                                <th>Cantidad de alumnos</th>
                                                <th>Colegio</th>
                                                <th>Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($rowCurso = $resultCurso->fetch_assoc()) : ?>
                                            <tr>
                                                <td style="color:blueviolet"> <?= $rowCurso['id_curso'] ?></td>
                                                <td> <?= $rowCurso['nombre_curso'] ?></td>
                                                <td> <?= $rowCurso['cantidad_alumnos'] ?></td>
                                                <td> <?= $rowCurso['nombre_de_colegio'] ?></td>
                                                <td>
                                                    <div class='d-flex gap-2'>
                                                        <div class='edit'>
                                                            <a
                                                                href="editCurso.php?id_curso=<?= $rowCurso['id_curso'] ?>">
                                                                <button type='button'
                                                                    class='btn btn-sm btn-info edit-item-btn'>Editar</button>
                                                            </a>
                                                        </div>
                                                        <div class='remove'>
                                                            <button class='btnCurso btn-sm btn-primary remove-item-btn'
                                                                data-bs-toggle='modal' data-bs-target='#deleteCurso'
                                                                style="background-color:blueviolet;color:white; border-radius:4px; border-color:blueviolet"
                                                                data-id_curso="<?= $rowCurso['id_curso'] ?>">Eliminar</button>
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
    <!-- END layout-wrapper -->

    <!-- Modal para eliminar -->
    <div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="btn-close"></button>
                </div>
                <div class="modal-body">
                    <div class="mt-2 text-center">
                        <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                            colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                        <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                            <h4>Eliminar colegio</h4>
                            <p class="text-muted mx-4 mb-0">¿Desea eliminar este colegio?</p>
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
            var id_colegio = this.getAttribute('data-id_colegio');
            // Guardar el valor de id en una variable
            var colegio_eliminar = id_colegio;

            // Mostrar el modal de eliminación
            document.getElementById('deleteRecordModal').style.display = 'none';

            // Después de confirmar la eliminación, oculta el modal y envía los datos a eliminarColegio.php
            document.getElementById('delete-record').addEventListener('click', function() {

                document.getElementById('deleteRecordModal').style.display = 'none';
                // Redirige a la página de eliminarColegio.php, junto con el parámetro de ID de la tabla para eliminar
                window.location.href = 'eliminarColegio.php?id_colegio=' + colegio_eliminar;
            });
        });
    });
    </script>

    <?php include 'includes/footerCliente.php'; ?>
    <?php include 'layouts/vendor-scripts.php'; ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

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

    <!-- Modal Reporte -->
    <script src="js\reporteModal.js"></script>
</body>

</html>