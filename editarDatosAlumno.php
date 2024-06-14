<!DOCTYPE html>
<html lang="es">

<?php include 'layouts/session.php'; ?>
<?php include 'layouts/main.php'; ?>

<?php
    include("modelo/conexion_bd.php");

    $conn = $conexion;

    $rut_cliente = $_SESSION['rut_cliente'];

    // Obtener el ID del colegio desde la URL
    $id_alumno = $_GET['id_alumno'];
    // Llamar al controlador para obtener los datos del colegio
    require_once ('controladorPagCliente/crud_alumno/controlador_alumno.php');
    $controlador = new ControladorAlumno();
    $alumno = $controlador->showAlumno($id_alumno);
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

                    <div class="position-relative mx-n4 mt-n4">
                        <div class="profile-wid-bg profile-setting-img">
                            <img src="micolegioImg/fondoDatoscliente.jpg" class="profile-wid-img" alt="">
                            <div class="overlay-content">
                                <div class="text-end p-3">
                                    <div class="p-0 ms-auto rounded-circle profile-photo-edit">
                                        <input id="profile-foreground-img-file-input" type="file" class="profile-foreground-img-file-input">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xxl-3">
                            <div class="card mt-n5">
                                <div class="card-body p-4">
                                    <div class="text-center">
                                        <div class="mx-auto avatar-md mb-3">
                                            <img src="micolegioImg/logo.png" alt="" class="img-fluid rounded-circle">
                                        </div>
                                        <?php if ($alumno): ?>
                                        <h5 class="fs-16 mb-1"><?= $alumno['nombre_alumno']. " " .$alumno['apellido_paterno']  ?></h5>
                                        <p class="text-muted mb-0"><?php echo $alumno['id_alumno']; ?></p>
                                    </div>
                                </div>
                            </div>
                            <!--end card-->
                            
                        </div>
                        <!--end col-->
                        <div class="col-xxl-9">
                            <div class="card mt-xxl-n5">
                                <div class="card-header">
                                    <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab">
                                                <i class="fas fa-home"></i> Datos personales
                                            </a>
                                        </li>
                                        
                                    </ul>
                                </div>
                                <div class="card-body p-4">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="personalDetails" role="tabpanel">
                                            <form action="updateAlumnoPagCliente.php" method="post">
                                                <div class="row">
                                                    
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="firstnameInput" class="form-label">ID alumno</label>
                                                            <input type="number" class="form-control" name="id_alumno" id="firstnameInput" placeholder="" value="<?php echo $alumno['id_alumno']; ?>" readonly required>
                                                        </div>
                                                    </div>
                                                    <!--end col-->

                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="firstnameInput" class="form-label">Nombres</label>
                                                            <input type="text" class="form-control" name="nombre_alumno" id="firstnameInput" placeholder="Ingrese su nombre" value="<?php echo $alumno['nombre_alumno']; ?>" required>
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="lastnameInput" class="form-label">Apellidos</label>
                                                            <input type="text" class="form-control" name="apellido_paterno" id="lastnameInput" placeholder="Ingrese su apellido" value="<?php echo $alumno['apellido_paterno']; ?>" required>
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="id_colegio" class="form-label">Colegio</label>
                                                            <select class="form-control" name="id_colegio" id="id_colegio" required>
                                                                <option value="<?php echo $alumno['id_colegio']; ?>"><?php echo $alumno['nombre_de_colegio']; ?></option>
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
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">        
                                                            <!-- HACER SELECT ANIDADO, SELECCIONA PRIMERO COLEGIO Y LUEGO 
                                                            VE CURSOS DISPONIBLES EN ESE COLEGIO (Select anidado no funciona con template, con "data-choices") -->
                                                            <label for="id_curso" class="form-label">Nombre curso</label>
                                                            <select class="form-control" name="id_curso" id="id_curso" required >
                                                                <option value="<?php echo $alumno['id_curso']; ?>"><?php echo $alumno['nombre_curso']; ?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <!--end col-->

                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="phonenumberInput" class="form-label">RUT apoderado</label>
                                                            <input type="text" class="form-control" name="rut_apoderado" id="phonenumberInput" placeholder="Ingrese el RUT" value="<?php echo $alumno['rut_apoderado']; ?>" required>
                                                        </div>
                                                    </div>
                                                    <!--end col-->

                                                    <script src="js/peticionesCurso.js"></script>

                                                    <?php endif; ?>                                 
                                                    
                                                    <div class="col-lg-12">
                                                        <div class="hstack gap-2 justify-content-end">
                                                            <button type="submit" class="btn btn-primary">Actualizar</button>
                                                            <a href="DatosUsuario.php">
                                                                <button type="button" class="btn btn-light">Volver</button>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                </div>
                                                <!--end row-->
                                            </form>
                                        </div>
                                        <!--end tab-pane-->
                                      
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->

                </div>
                <!-- container-fluid -->
            </div><!-- End Page-content -->

        </div>
        <!-- end main content-->

    <?php include 'layouts/vendor-scripts.php'; ?>

    <!-- profile-setting init js -->
    <script src="assets/js/pages/profile-setting.init.js"></script>

    <!-- App js -->
    <script src="assets/js/app.js"></script>
</body>

</html>