<!DOCTYPE html>
<html lang="es">

<?php include 'layouts/session.php'; ?>
<?php include 'layouts/main.php'; ?>

<?php
    include("modelo/conexion_bd.php");

    $conn = $conexion;

    $rut_cliente = $_SESSION['rut_cliente'];

    $sql = "SELECT id_alumno, nombre_alumno, apellido_paterno, alumno.id_curso, rut_apoderado,
    colegio.nombre_de_colegio, curso.nombre_curso
    FROM alumno 
    JOIN curso ON alumno.id_curso = curso.id_curso 
    JOIN colegio ON curso.id_colegio = colegio.id_colegio
    WHERE alumno.rut_apoderado = ". $rut_cliente;
    $result = $conn->query($sql);

    $sqlCliente = "SELECT rut_cliente, nombre_cliente, apellido_cliente, clave,
    email, telefono, direccion, parentesco, cliente.id_comuna, nombre_comuna, 
	nombre_region
    FROM cliente 
    JOIN comuna ON cliente.id_comuna = comuna.id_comuna 
    JOIN region ON comuna.id_region = region.id_region
    WHERE cliente.rut_cliente = ". $rut_cliente;
    $resultCliente = $conn->query($sqlCliente);
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
                    <div class="profile-foreground position-relative mx-n4 mt-n4">
                        <div class="profile-wid-bg">
                            <img src="micolegioImg/fondoDatoscliente.jpg" alt="" class="profile-wid-img" />
                        </div>
                    </div>
                    <div class="pt-4 mb-4 mb-lg-3 pb-lg-4 profile-wrapper">
                        <div class="row g-4">
                            
                            <div class="col">
                                <div class="p-2">
                                    <h3 class="text-white mb-1" style="font-size: 40px;"><?php echo $_SESSION['nombre_cliente'] . " " . $_SESSION['apellido_cliente']; ?></h3>
                                    <p class="text-white text-opacity-75" style="font-size: 25px;color:white"><?php echo $_SESSION['rut_cliente']; ?></p>
                                    <div class="hstack text-white-50 gap-1">
                                        <div class="me-2" style="font-size: 20px;"><i class="ri-map-pin-user-line me-1 text-white text-opacity-75 fs-16 align-middle"></i><?php echo $_SESSION['direccion']; ?></div>
                                    </div>
                                </div>
                            </div>
                            <!--end col-->

                        </div>
                        <!--end row-->
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div>
                                <div class="d-flex profile-wrapper">
                                    <div class="flex-shrink-0" >
                                        <a href="editarDatosCliente.php" class="btn btn-info" style="background-color: #7000FF;"><i class="ri-edit-box-line align-bottom"></i> Editar datos</a>
                                    </div>
                                </div>
                                <!-- Tab panes -->
                                <div class="tab-content pt-4 text-muted">
                                    <div class="tab-pane active" id="overview-tab" role="tabpanel">
                                        <div class="row">
                                            <div class="col-xxl-3">

                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="card-title mb-3" style="font-size: 25px;">Información</h5>
                                                        <div class="table-responsive">
                                                            <table class="table table-borderless mb-0">
                                                                <tbody style="font-size: 17px;">
                                                                    <?php while ($row = $resultCliente->fetch_assoc()): ?>
                                                                    <tr>
                                                                        <th class="ps-0" scope="row">RUT :</th>
                                                                        <td class="text-muted"><?php echo $row['rut_cliente']; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="ps-0" scope="row">Nombre :</th>
                                                                        <td class="text-muted"><?php echo $row['nombre_cliente'] . " " . $row['apellido_cliente']; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="ps-0" scope="row">Teléfono :</th>
                                                                        <td class="text-muted"><?php echo $row['telefono']; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="ps-0" scope="row">Email :</th>
                                                                        <td class="text-muted"><?php echo $row['email']; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="ps-0" scope="row">Parentesco :</th>
                                                                        <td class="text-muted"><?php echo $row['parentesco']; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="ps-0" scope="row">Dirección :</th>
                                                                        <td class="text-muted"><?php echo $row['direccion']; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="ps-0" scope="row">Comuna :</th>
                                                                        <td class="text-muted"><?php echo $row['nombre_comuna']; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="ps-0" scope="row">Región :</th>
                                                                        <td class="text-muted"><?php echo $row['nombre_region']; ?></td>
                                                                    </tr>
                                                                    <?php endwhile; ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div><!-- end card body -->
                                                </div><!-- end card -->
                                            </div>
                                            <!--end col-->
                                            <div class="col-xxl-9">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="card">
                                                            <div class="card-header align-items-center d-flex">
                                                                <h4 class="card-title mb-0 me-auto">Alumnos registrados</h4>
                                                                <button type='button' class='btn btn-info add-btn ms-auto' data-bs-toggle='modal' id="create-btn" data-bs-target='#exampleModalgrid' style="background-color:blueviolet;"><i class="ri-add-line align-bottom me-1"></i>Agregar alumno</button>
                                                            </div>

                                                            <!-- ALUMNOS ASOCIADOS AL CLIENTE -->
                                                            <div class="card-body">
                                                                <div class="tab-content text-muted">
                                                                    <div class="tab-pane active" id="today" role="tabpanel">
                                                                        <div class="profile-timeline">
                                                                            <div class="accordion accordion-flush" id="todayExample">
                                                                                <div class="row">
                                                                                    <?php while ($row = $result->fetch_assoc()): ?>
                                                                                    <div class="col-xl-4">
                                                                                        <div class="card">
                                                                                            <div class="card-header">
                                                                                                <h6 class="card-title mb-0">Alumno</h6>
                                                                                            </div>
                                                                                            <div class="card-body p-4 text-center">
                                                                                                <div class="mx-auto avatar-md mb-3">
                                                                                                    <img src="micolegioImg/logo.png" alt="" class="img-fluid rounded-circle">
                                                                                                </div>
                                                                                                <h5 class="card-title mb-1" style="display: none;"><?=  $row['id_alumno'] ?></h5>
                                                                                                <h5 class="card-title mb-1"><?=  $row['nombre_alumno'] . " " . $row['apellido_paterno'] ?></h5>
                                                                                                <p class="text-muted mb-0"><?=  $row['nombre_curso'] ?></p>
                                                                                                <p class="text-muted mb-0"><?=  $row['nombre_de_colegio'] ?></p>
                                                                                                <a href="editarDatosAlumno.php?id_alumno=<?= $row['id_alumno'] ?>">
                                                                                                    <button type='button' class='btn btn-sm btn-info edit-item-btn' style="background-color: blueviolet; margin-top:10px"><i class="ri-edit-box-line align-bottom"></i> Editar</button>
                                                                                                </a>
                                                                                                <button class='btn btn-sm btn-primary remove-item-btn' data-bs-toggle='modal' style="margin-top: 10px;" data-bs-target='#deleteRecordModal' data-id_producto="<?= $row['id_alumno'] ?>">Eliminar</button>

                                                                                                
                                                                                            </div>
                                                                                            <div class="card-footer text-center">
                                                                                                
                                                                                            </div>
                                                                                        </div>
                                                                                    </div><!-- end col -->
                                                                                    <?php endwhile; ?>
                                                                                    
                                                                                </div><!-- end row -->
                                                                                
                                                                            </div>
                                                                            <!--end accordion-->
                                                                        </div>
                                                                    </div>
                                                                   
                                                                </div>
                                                            </div><!-- end card body -->
                                                        </div><!-- end card -->
                                                    </div><!-- end col -->
                                                </div><!-- end row -->

                                            </div>
                                            <!--end col-->
                                
                                        </div>
                                        <!--end row-->
                                    </div>
                                    
                                </div>
                                <!--end tab-content-->
                            </div>
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->

                </div><!-- container-fluid -->
            </div><!-- End Page-content -->

        </div><!-- end main content-->

        <!-- MODAL PARA INGRESAR ALUMNO -->
        <div class="modal fade" id="exampleModalgrid" tabindex="-1" aria-labelledby="exampleModalgridLabel" aria-modal="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalgridLabel" style="font-size: 30px;">Añadir alumno</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="procesarAlumnoPagCliente.php" method="post" class="tablelist-form">
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
                                        <input type="text" class="form-control" id="nombre_alumno" name="nombre_alumno" value="" placeholder="Nombre alumno" oninput="capitalizeFirstLetter(this)" required>
                                    </div>
                                </div><!--end col-->

                                <div class="col-xxl-6">
                                    <div>
                                        <label for="apellido_paterno" class="form-label" style="margin-top: 0px;">Apellido alumno</label>
                                        <input type="text" class="form-control" id="apellido_paterno" name="apellido_paterno" value="" placeholder="Apellido alumno" oninput="capitalizeFirstLetter(this)" required>
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
                                        <input type="text" class="form-control" id="rut_apoderado" name="rut_apoderado" value="<?php echo $_SESSION['rut_cliente']; ?>" placeholder="Nombre alumno" required readonly>
                                        
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
                        window.location.href = 'eliminarAlumnoPagCliente.php?id_alumno=' + alumno_eliminar;
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

    <!-- apexcharts -->
    <script src="assets/libs/apexcharts/apexcharts.min.js"></script>

    <!-- Vector map-->
    <script src="assets/libs/jsvectormap/js/jsvectormap.min.js"></script>
    <script src="assets/libs/jsvectormap/maps/world-merc.js"></script>

    <!--Swiper slider js-->
    <script src="assets/libs/swiper/swiper-bundle.min.js"></script>

    <!-- Dashboard init -->
    <script src="assets/js/pages/dashboard-ecommerce.init.js"></script>

    <!-- App js -->
    <script src="assets/js/app.js"></script>

    <!-- swiper js -->
    <script src="assets/libs/swiper/swiper-bundle.min.js"></script>

    <!-- profile init js -->
    <script src="assets/js/pages/profile.init.js"></script>

    <!-- App js -->
    <script src="assets/js/app.js"></script>

</body>
</html>