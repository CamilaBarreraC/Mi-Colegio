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
    <?php include 'includes/sidebar.php'; ?>
    <?php include 'includes/topbar.php'; ?>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <?php includeFileWithVariables('layouts/page-title.php', array('pagetitle' => 'Tables', 'title' => 'Colegios')); ?>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0" style="font-size: 35px;">Colegios</h5>
                                </div>
                                <div class="card-body">
                                    <button type='button' class='btn btn-info add-btn' data-bs-toggle='modal'
                                        id="create-btn" data-bs-target='#exampleModalgrid'
                                        style="background-color:blueviolet;margin-bottom: 20px"><i
                                            class="ri-add-line align-bottom me-1"></i>
                                        Añadir colegio
                                    </button>
                                    <!--Excel-->
                                    <form action="reporteExcel.php" method="post">
                                        <button type="submit" class="btn btn-primary" name="reporte_colegio"
                                            style="background-color:green; margin-bottom: 20px;">
                                            <img style="width:20px; height:auto;" src="image/icono-excel.png"
                                                alt="Excel Icon" class="icon">
                                        </button>
                                    </form>

                                    <!--PDF-->
                                    <form action="reportePDF.php" method="post">
                                        <button type="submit" class="btn btn-primary" name="reporte_colegio"
                                            style="background-color:red;margin-bottom: 20px">
                                            <img style="width:20px; height:auto;" src="image/icono-pdf.png"
                                                alt="PDF Icon" class="icon">
                                        </button>
                                    </form>




                                    <table id="alternative-pagination"
                                        class="table nowrap dt-responsive align-middle table-hover table-bordered"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>ID colegio</th>
                                                <th>Nombre colegio</th>
                                                <th>Comuna</th>
                                                <th>Región</th>
                                                <th>Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($row = $result->fetch_assoc()) : ?>
                                            <tr>
                                                <td style="color:blue"> <?= $row['id_colegio'] ?></td>
                                                <td> <?= $row['nombre_de_colegio'] ?></td>
                                                <td> <?= $row['nombre_comuna'] ?></td>
                                                <td> <?= $row['nombre_region'] ?></td>
                                                <td>
                                                    <div class='d-flex gap-2'>
                                                        <div class='edit'>
                                                            <a
                                                                href="editColegio.php?id_colegio=<?= $row['id_colegio'] ?>">
                                                                <button type='button'
                                                                    class='btn btn-sm btn-info edit-item-btn'>Editar</button>
                                                            </a>
                                                        </div>
                                                        <div class='remove'>
                                                            <button class='btn btn-sm btn-primary remove-item-btn'
                                                                data-bs-toggle='modal'
                                                                data-bs-target='#deleteRecordModal'
                                                                data-id_colegio="<?= $row['id_colegio'] ?>">Eliminar</button>
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
                                    <h5 class="card-title mb-0" style="font-size: 35px;">Cursos</h5>
                                </div>
                                <div class="card-body">

                                    <button type='button' class='btn btn-info add-btn' data-bs-toggle='modal'
                                        id="create-btn" data-bs-target='#ModalgridCurso'
                                        style="background-color:darkslateblue;margin-bottom: 20px"><i
                                            class="ri-add-line align-bottom me-1"></i>Añadir curso</button>

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
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- OPCIONES DE COLEGIO -->

    <!-- MODAL PARA INGRESAR COLEGIO -->
    <div class="modal fade" id="exampleModalgrid" tabindex="-1" aria-labelledby="exampleModalgridLabel"
        aria-modal="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalgridLabel" style="font-size: 30px;">Añadir Colegio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="procesarColegio.php" method="post" class="tablelist-form">
                        <div class="row g-3">
                            <div class="col-xxl-6" style="display: none;">
                                <div style="display: none;">
                                    <label for="id_colegio" class="form-label" style="margin-top: 0px; display:none">ID
                                        colegio</label>
                                    <input type="text" class="form-control" id="id_colegio" name="id_colegio" value=""
                                        placeholder="ID colegio" style="display: none;">
                                </div>
                            </div>
                            <!--end col-->

                            <div class="col-xxl-6">
                                <div>
                                    <label for="nombre_de_colegio" class="form-label" style="margin-top: 0px;">Nombre
                                        colegio</label>
                                    <input type="text" class="form-control" id="nombre_de_colegio"
                                        name="nombre_de_colegio" value="" placeholder="Nombre colegio">
                                </div>
                            </div>
                            <!--end col-->

                            <div class="col-xxl-6">
                                <div>
                                    <label for="choices-single-default" class="form-label">Comuna</label>
                                    <select class="form-control" data-choices name="id_comuna"
                                        id="choices-single-default" required>
                                        <option value="">Seleccione la comuna</option>
                                        <?php
                                        // Establecer conexión a la base de datos
                                        include("modelo\conexion_bd.php");

                                        // Consulta SQL para obtener las opciones
                                        $sql = "SELECT id_comuna, nombre_comuna FROM comuna";
                                        $resultComunas = $conexion->query($sql);

                                        // Confirma si hay resultados, ordenandolos por id 
                                        // Si no hay datos, muestra la opción de no hay registros
                                        if ($result->num_rows > 0) {
                                            while ($row = $resultComunas->fetch_assoc()) {
                                                echo "<option value='" . $row["id_comuna"] . "'>" . $row["nombre_comuna"] . "</option>";
                                            }
                                        } else {
                                            echo "<option value=''>No hay registros de comunas</option>";
                                        }

                                        $conexion->close();
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <!--end col-->

                            <div class="col-xxl-6">
                                <div>
                                    <label for="direccion" class="form-label">Dirección</label>
                                    <input type="text" class="form-control" id="direccion" name="direccion" value=""
                                        placeholder="Dirección" required>
                                </div>
                            </div>
                            <!--end col-->

                            <div class="col-lg-12">
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Ingresar</button>
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
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

    <!-- OPCIONES DE CURSO -->

    <!-- MODAL PARA INGRESAR CURSO -->
    <div class="modal fade" id="ModalgridCurso" tabindex="-1" aria-labelledby="exampleModalgridLabel" aria-modal="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalgridLabel" style="font-size: 30px;">Añadir Curso</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="procesarCurso.php" method="post" class="tablelist-form">
                        <div class="row g-3">
                            <div class="col-xxl-6">
                                <div>
                                    <label for="choices-single-default" class="form-label"
                                        style="margin-top: 0px;">Nombre curso</label>
                                    <select class="form-control" data-choices name="nombre_curso"
                                        id="choices-single-default" required>
                                        <option value="">Seleccione el curso</option>
                                        <option value="Pre-Kinder" required>Pre-Kinder</option>
                                        <option value="Kinder" required>Kinder</option>
                                        <option value="1° Básico" required>1° Básico</option>
                                        <option value="2° Básico" required>2° Básico</option>
                                        <option value="3° Básico" required>3° Básico</option>
                                        <option value="4° Básico" required>4° Básico</option>
                                        <option value="5° Básico" required>5° Básico</option>
                                        <option value="6° Básico" required>6° Básico</option>
                                        <option value="7° Básico" required>7° Básico</option>
                                        <option value="8° Básico" required>8° Básico</option>
                                        <option value="1° Medio" required>1° Medio</option>
                                        <option value="2° Medio" required>2° Medio</option>
                                        <option value="3° Medio" required>3° Medio</option>
                                        <option value="4° Medio" required>4° Medio</option>
                                    </select>
                                </div>
                            </div>
                            <!--end col-->

                            <div class="col-xxl-6">
                                <div>
                                    <label for="cantidad_alumnos" class="form-label">Cantidad de alumnos</label>
                                    <select class="form-control" data-trigger name="cantidad_alumnos" id="status-field"
                                        required>
                                        <option value="">Seleccione la cantidad</option>
                                        <option value="25" required>25</option>
                                        <option value="30" required>30</option>
                                        <option value="35" required>35</option>
                                        <option value="40" required>40</option>
                                    </select>
                                </div>
                            </div>
                            <!--end col-->

                            <div class="col-xxl-6">
                                <div>
                                    <label for="choices-single-default" class="form-label">Colegio</label>
                                    <select class="form-control" data-choices name="id_colegio"
                                        id="choices-single-default" required>
                                        <option value="">Seleccione el colegio</option>
                                        <?php
                                        // Establecer conexión a la base de datos
                                        include("modelo\conexion_bd.php");

                                        // Consulta SQL para obtener las opciones
                                        $sql = "SELECT id_colegio, nombre_de_colegio FROM colegio";
                                        $resultColegios = $conexion->query($sql);

                                        // Confirma si hay resultados, ordenandolos por id 
                                        // Si no hay datos, muestra la opción de no hay registros
                                        if ($result->num_rows > 0) {
                                            while ($row = $resultColegios->fetch_assoc()) {
                                                echo "<option value='" . $row["id_colegio"] . "'>" . $row["nombre_de_colegio"] . "</option>";
                                            }
                                        } else {
                                            echo "<option value=''>No hay registros de colegios</option>";
                                        }

                                        $conexion->close();
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <!--end col-->

                            <div class="col-lg-12">
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Ingresar</button>
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
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
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="btn-close"></button>
                </div>
                <div class="modal-body">
                    <div class="mt-2 text-center">
                        <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                            colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                        <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                            <h4>Eliminar curso</h4>
                            <p class="text-muted mx-4 mb-0">¿Desea eliminar este curso?</p>
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
            var id_curso = this.getAttribute('data-id_curso');
            // Guardar el valor de id en una variable
            var curso_eliminar = id_curso;

            // Mostrar el modal de eliminación
            document.getElementById('deleteCurso').style.display = 'none';

            // Después de confirmar la eliminación, oculta el modal y envía los datos a eliminarCurso.php
            document.getElementById('delete-recordCurso').addEventListener('click', function() {

                document.getElementById('deleteCurso').style.display = 'none';
                // Redirige a la página de eliminarCurso.php, junto con el parámetro de ID de la tabla para eliminar
                window.location.href = 'eliminarCurso.php?id_curso=' + curso_eliminar;
            });
        });
    });
    </script>

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