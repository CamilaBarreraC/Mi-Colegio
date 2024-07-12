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
    JOIN region ON comuna.id_region = region.id_region";
$result = $conn->query($sql);

$colegio = "";

// Agrega WHERE según los valores de los selects con filtros
if (empty($_POST['xcolegio'])) {
    $sql = "SELECT id_colegio, nombre_de_colegio, colegio.id_comuna, direccion, nombre_comuna, nombre_region 
    FROM colegio 
    JOIN comuna ON colegio.id_comuna = comuna.id_comuna 
    JOIN region ON comuna.id_region = region.id_region";
}else{
    $colegio = $_POST['xcolegio'];
    $sql .= " WHERE comuna.id_region = $colegio";
}

$result = $conn->query($sql);

//consulta sobre la comuna 

$comuna = "";

if (empty($_POST['xcomuna'])) {
    $sql = "SELECT id_colegio, nombre_de_colegio, colegio.id_comuna, direccion, nombre_comuna, nombre_region 
    FROM colegio 
    JOIN comuna ON colegio.id_comuna = comuna.id_comuna 
    JOIN region ON comuna.id_region = region.id_region";
}else{
    $comuna = $_POST['xcomuna'];
    $sql .= " WHERE comuna.id_comuna = $comuna";
}

$result1 = $conn->query($sql);

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
                                    <div class="accordion accordion-flush filter-accordion">
    <div class="accordion-item">
        <div id="flush-collapseBrands" class="accordion-collapse collapse show" aria-labelledby="flush-headingBrands">
            <div class="accordion-body text-body pt-0">
                <div class="d-flex flex-row align-items-center gap-2 mt-3 filter-check">
                    <form class="d-flex flex-row align-items-center" method="post">
                        <select name="xcolegio" class="form-select me-2">
                            <option value="">Seleccione región</option>
                            <?php
                            // Consulta SQL para obtener las opciones
                            $sql = "SELECT id_region, nombre_region FROM region";
                            $resultCat = $conn->query($sql);

                            // Confirma si hay resultados
                            if ($resultCat->num_rows > 0) {
                                while ($row = $resultCat->fetch_assoc()) {
                                    echo "<option value='" . $row["id_region"] . "'>" . $row["nombre_region"] . "</option>";
                                }
                            } else {
                                echo "<option value=''>No hay registros de categorías</option>";
                            }
                            ?>
                        </select>
                        <select name="xcomuna" class="form-select me-2">
                            <option value="">Seleccione comuna</option>
                            <?php
                            // Consulta SQL para obtener las opciones
                            $sql = "SELECT id_comuna, nombre_comuna FROM comuna";
                            $resultCat = $conn->query($sql);

                            // Confirma si hay resultados
                            if ($resultCat->num_rows > 0) {
                                while ($row = $resultCat->fetch_assoc()) {
                                    echo "<option value='" . $row["id_comuna"] . "'>" . $row["nombre_comuna"] . "</option>";
                                }
                            } else {
                                echo "<option value=''>No hay registros de categorías</option>";
                            }
                            ?>
                        </select>
                        <button type="submit" class="btn btn-primary rounded-pill" style="font-size: 15px;" name="buscar"><i class="ri-equalizer-fill me-2 align-bottom"></i>Filtrar</button>
                    </form>
                    <a href="Colegios.php" class="link-secondary ms-3">Limpiar filtros</a>
                </div>
            </div>
        </div>
    </div>
</div>
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
                                                <td > <?= $row['nombre_region'] ?></td>
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