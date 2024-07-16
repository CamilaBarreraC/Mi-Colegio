<!DOCTYPE html>
<html lang="es">

<?php include 'layouts/session.php'; ?>
<?php include 'layouts/main.php'; ?>

<?php
    include("modelo/conexion_bd.php");

    $conn = $conexion;

    $sql = "SELECT id_alumno, nombre_alumno, apellido_paterno, alumno.id_curso, rut_apoderado, 
    nombre_curso, cliente.rut_cliente, cliente.nombre_cliente, cliente.apellido_cliente, colegio.nombre_de_colegio
    FROM alumno 
    JOIN cliente ON cliente.rut_cliente = alumno.rut_apoderado
    JOIN curso ON curso.id_curso = alumno.id_curso
    JOIN colegio ON curso.id_colegio = colegio.id_colegio;";
    $result = $conn->query($sql);

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

                    <?php includeFileWithVariables('layouts/page-title.php', array('pagetitle' => 'Tables', 'title' => 'Alumnos')); ?>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0" style="font-size: 35px;">Alumnos</h5>
                                </div>
                                <div class="card-body">
                                    <button type='button' class='btn btn-info add-btn' data-bs-toggle='modal' id="create-btn" data-bs-target='#exampleModalgrid' style="background-color:blueviolet;margin-bottom: 20px" ><i class="ri-add-line align-bottom me-1"></i>Añadir alumno</button>

                                    <table id="alternative-pagination" class="table nowrap dt-responsive align-middle table-hover table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>ID alumno</th>
                                                <th>Nombre alumno</th>
                                                <th>Curso</th>
                                                <th>Colegio</th>
                                                <th>Apoderado</th>
                                                <th>Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($row = $result->fetch_assoc()): ?>
                                            <tr>
                                                <td style="color:blue"> <?=  $row['id_alumno'] ?></td>
                                                <td> <?= $row['nombre_alumno'] . " " . $row['apellido_paterno'] ?></td>                              
                                                <td> <?= $row['nombre_curso'] ?></td>
                                                <td> <?= $row['nombre_de_colegio'] ?></td>
                                                <td> <?= $row['nombre_cliente'] . " " . $row['apellido_cliente'] ?></td>
                                                
                                                <td>
                                                    <div class='d-flex gap-2'>
                                                        <div class='edit'>
                                                            <a href="editAlumno.php?id_alumno=<?= $row['id_alumno'] ?>">
                                                                <button type='button' class='btn btn-sm btn-info edit-item-btn'>Editar</button>
                                                            </a>
                                                        </div>
                                                        <div class='remove'>
                                                            <button class='btn btn-sm btn-primary remove-item-btn' data-bs-toggle='modal' data-bs-target='#deleteRecordModal' data-id_producto="<?= $row['id_alumno'] ?>">Eliminar</button>
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

    <!-- OPCIONES DE LISTA 1 -->

    <!-- MODAL PARA INGRESAR LISTA 1 -->
    <div class="modal fade" id="exampleModalgrid" tabindex="-1" aria-labelledby="exampleModalgridLabel" aria-modal="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalgridLabel" style="font-size: 30px;">Añadir alumno</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="procesarAlumno.php" method="post" class="tablelist-form">
                        <div class="row g-3">
                            <div class="col-xxl-6" style="display: none;">
                                <div style="display: none;">
                                    <label for="id_alumno" class="form-label" style="margin-top: 0px; display:none">ID alumno</label>
                                    <input type="text" class="form-control" id="id_alumno" name="id_alumno" value="" placeholder="ID alumno" style="display: none;" >
                                </div>
                            </div><!--end col-->

                            <div class="col-xxl-6">
                                <div>
                                    <label for="nombre_alumno" class="form-label" style="margin-top: 0px;">Nombre alumno</label>
                                    <input type="text" class="form-control" id="nombre_alumno" name="nombre_alumno" value="" placeholder="Nombre alumno" required oninput="capitalizeFirstLetter(this)">
                                </div>
                            </div><!--end col-->

                            <div class="col-xxl-6">
                                <div>
                                    <label for="apellido_paterno" class="form-label" style="margin-top: 0px;">Apellido alumno</label>
                                    <input type="text" class="form-control" id="apellido_paterno" name="apellido_paterno" value="" placeholder="Apellido alumno" required oninput="capitalizeFirstLetter(this)">
                                </div>
                            </div><!--end col-->
                            
                            <div class="col-xxl-6">
                                <div>
                                    <label for="id_colegio" class="form-label">Colegio</label>
                                    <select class="form-control" name="id_colegio" id="id_colegio" required>
                                        <option value="">Seleccione colegio</option>
                                        <?php
                                            // Establecer conexión a la base de datos
                                            include("modelo\conexion_bd.php");

                                            // Consulta SQL para obtener las opciones
                                            $sql = "SELECT id_colegio, nombre_de_colegio FROM colegio";
                                            $resultColegios = $conexion->query($sql);

                                            // Confirma si hay resultados, ordenandolos por id 
                                            // Si no hay datos, muestra la opción de no hay registros
                                            if ($resultColegios->num_rows > 0){
                                                while($row = $resultColegios->fetch_assoc()) {
                                                    echo "<option value='" . $row["id_colegio"] . "'>" . $row["nombre_de_colegio"] . "</option>";
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
                                    <!-- HACER SELECT ANIDADO, SELECCIONA PRIMERO COLEGIO Y LUEGO 
                                    VE CURSOS DISPONIBLES EN ESE COLEGIO (Select anidado no funciona con template, con "data-choices") -->
                                    <label for="id_curso" class="form-label" style="margin-top: 0px;">Nombre curso</label>
                                    <select class="form-control" name="id_curso" id="id_curso" required >
                                        <option value="">Seleccione curso</option>
                                    </select>

                                </div>
                            </div><!--end col-->

                            <div class="col-xxl-6">
                                <div>
                                    <label for="rut_apoderado" class="form-label">RUT apoderado</label>
                                    <select class="form-control" name="rut_apoderado" id="rut_apoderado" required>
                                        <option value="">Seleccione apoderado</option>
                                        <?php
                                            // Establecer conexión a la base de datos
                                            include("modelo\conexion_bd.php");

                                            // Consulta SQL para obtener las opciones
                                            $sql = "SELECT rut_cliente, nombre_cliente, apellido_cliente FROM cliente";
                                            $resultColegios = $conexion->query($sql);

                                            // Confirma si hay resultados, ordenandolos por id 
                                            // Si no hay datos, muestra la opción de no hay registros
                                            if ($resultColegios->num_rows > 0){
                                                while($row = $resultColegios->fetch_assoc()) {
                                                    echo "<option value='" . $row["rut_cliente"] . "'>" . $row["rut_cliente"] . " " .$row["nombre_cliente"] . " " .$row["apellido_cliente"] . "</option>";
                                                }
                                            }else{
                                                echo "<option value=''>No hay registros de apoderados</option>";
                                            }
                                        $conexion->close();
                                        ?>
                                    </select>
                                    
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
                            <h4>Eliminar alumno</h4>
                            <p class="text-muted mx-4 mb-0">¿Desea eliminar este alumno?</p>
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
                var id_alumno = this.getAttribute('data-id_producto');
                // Guardar el valor de id en una variable
                var alumno_eliminar = id_alumno;

                // Mostrar el modal de eliminación
                document.getElementById('deleteRecordModal').style.display = 'none';

                // Después de confirmar la eliminación, oculta el modal y envía los datos a eliminarColegio.php
                document.getElementById('delete-record').addEventListener('click', function() {
                                    
                    document.getElementById('deleteRecordModal').style.display = 'none';
                    // Redirige a la página de eliminarColegio.php, junto con el parámetro de ID de la tabla para eliminar
                    window.location.href = 'eliminarAlumno.php?id_alumno=' + alumno_eliminar;
                });
            });
        });
    </script>

    <script>
        function capitalizeFirstLetter(input) {
            const words = input.value.split(' ');
            for (let i = 0; i < words.length; i++) {
                if (words[i].length > 0) {
                    words[i] = words[i][0].toUpperCase() + words[i].substring(1).toLowerCase();
                }
            }
            input.value = words.join(' ');
        }
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