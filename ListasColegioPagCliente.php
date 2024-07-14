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
    <link rel="icon" type="icon" href="micolegioImg/logo icono.png"/>

    <link rel="stylesheet" href="css/estiloPagCliente.css">  

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- glightbox css -->
    <link rel="stylesheet" href="assets/libs/glightbox/css/glightbox.min.css">

    <?php includeFileWithVariables('layouts/title-meta.php', array('title' => 'Dashboard')); ?>

    <!-- jsvectormap css -->
    <link href="assets/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css" />

    <!--Swiper slider css-->
    <link href="assets/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css" />

    <?php include 'layouts/head-css.php'; ?>
</head>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Arsenal:ital,wght@0,400;0,700;1,400;1,700&family=Barlow:ital,wght@1,500&display=swap');
    @import url(https://fonts.googleapis.com/css2?family=Barlow:wght@100&display=swap);
    @import url(https://fonts.googleapis.com/css2?family=Barlow:wght@700&display=swap);
    @import url(https://fonts.googleapis.com/css2?family=Barlow:ital,wght@1,500&display=swap);
    @import url(https://fonts.googleapis.com/css2?family=Aleo&display=swap);
    @import url(https://fonts.googleapis.com/css2?family=Barlow:ital,wght@1,600&display=swap);

    .img_fondo_productos{
        background-image: url(micolegioImg/fondoColegiosCliente.png) ;
        width:100%;
        height: 250px;
        flex-grow: 0;
        margin: 102px 49px 0 50px;
        padding: 59.5px 4.5px 51.9px 567.2px;
        background-size: cover;
        border-radius: 50px;
    }

    .card_alumnos:hover{
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.20);
    }

    .card{
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.20);
    }

    .btn:hover{
        transform: scale(1.1);
        border-color: blue;
    }

</style>

<body style="background-color:azure;">

    <?php include 'includes/topbarCliente.php'; ?>
    <?php include 'includes/sidebar2.php'; ?>

    <div class="container_productos" style="display: grid;place-items: center; width:100%">
        <div class="img_fondo_productos" style="width: 90%;"> </div>
    </div>

    <div id="layout-wrapper">
        <div class="page-content">
            <div class="container-fluid">        
                <div class="row">
                    <div class="col-lg-12">
                        <div>
                            <div class="tab-content pt-4 text-muted">
                                <div class="tab-pane active" id="overview-tab" role="tabpanel">
                                    <div class="row">

                                        <div class="col-xxl-3">
                                            <div class="card">
                                                <div class="card-body">
                                                    <button type='button' class='btn btn-info add-btn ms-auto' data-bs-toggle='modal' id="create-btn" data-bs-target='#exampleModalgrid' style="background-color: #7000FF;font-size:20px; border-radius:20px"><i class="ri-edit-box-line align-bottom"></i>Buscar lista por colegio y curso</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xxl-9">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="card">
                                                        <div class="card-header align-items-center d-flex">
                                                            <h4 class="card-title mb-0 me-auto" style="font-size: 25px;">Seleccione un alumno para buscar su lista escolar</h4>
                                                            <a href="DatosUsuario.php">
                                                                <button type='button' class='btn btn-info add-btn ms-auto' data-bs-toggle='modal' id="create-btn" style="background-color:blueviolet;"><i class="ri-add-line align-bottom me-1"></i>Agregar alumno</button>
                                                            </a>
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
                                                                                    <div class="card_alumnos">
                                                                                        <div class="card-header">
                                                                                            <h6 class="card-title mb-0">RUT apoderado: <?=  $row['rut_apoderado'] ?></h6>
                                                                                        </div>
                                                                                        <div class="card-body p-4 text-center">
                                                                                            <div class="mx-auto avatar-md mb-3">
                                                                                                <img src="micolegioImg/logo.png" alt="" class="img-fluid rounded-circle">
                                                                                            </div>
                                                                                            <h5 class="card-title mb-1" style="display: none;"><?=  $row['id_alumno'] ?></h5>
                                                                                            <h5 class="card-title mb-1"><?=  $row['nombre_alumno'] . " " . $row['apellido_paterno'] ?></h5>
                                                                                            <p class="text-muted mb-0"><?=  $row['nombre_curso'] ?></p>
                                                                                            <p class="text-muted mb-0"><?=  $row['nombre_de_colegio'] ?></p>
                                                                                            <a href="ListaAlumnoPagCliente.php?id_alumno=<?= $row['id_alumno'] ?>">
                                                                                                <button type='button' class='btn btn-sm btn-info edit-item-btn' style="background-color: blueviolet; margin-top:10px"> Seleccionar</button>
                                                                                            </a>                                    
                                                                                                
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
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end row-->
                </div>

            </div><!-- container-fluid -->
        </div><!-- End Page-content -->
    </div>

        <!-- MODAL PARA BUSCAR COLEGIO POR REGÍON Y COMUNA -->
        <div class="modal fade" id="exampleModalgrid" tabindex="-1" aria-labelledby="exampleModalgridLabel" aria-modal="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalgridLabel" style="font-size: 30px;">Buscar colegio</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="procesarAlumnoPagCliente.php" method="post" class="tablelist-form">
                            <div class="row g-3">

                                <div class="col-xxl-6">
                                    <div>
                                        <label for="id_region" class="form-label">Región</label>
                                        <select class="form-control" name="id_region" id="id_region" required>
                                            <option value="">Seleccione región</option>
                                            <?php
                                                // Establecer conexión a la base de datos
                                                include("modelo\conexion_bd.php");

                                                // Consulta SQL para obtener las opciones
                                                $sql = "SELECT id_region, nombre_region FROM region";
                                                $resultColegios = $conexion->query($sql);

                                                // Confirma si hay resultados, ordenandolos por id 
                                                // Si no hay datos, muestra la opción de no hay registros
                                                if ($resultColegios->num_rows > 0){
                                                    while($row = $resultColegios->fetch_assoc()) {
                                                        echo "<option value='" . $row["id_region"] . "'>" . $row["nombre_region"] . "</option>";
                                                    }
                                                }else{
                                                    echo "<option value=''>No hay registros de regiones</option>";
                                                }
                                            $conexion->close();
                                            ?>
                                        </select>
                                    </div>
                                </div><!--end col-->

                                <div class="col-xxl-6">
                                    <div>
                                        <label for="id_comuna" class="form-label">Comuna</label>
                                        <select class="form-control" name="id_comuna" id="id_comuna" required>
                                            <option value="">Seleccione comuna</option>
                                        </select>
                                    </div>
                                </div><!--end col-->
                                
                                <div class="col-xxl-6">
                                    <div>
                                        <label for="id_colegio" class="form-label">Colegio</label>
                                        <select class="form-control" name="id_colegio" id="id_colegio" required>
                                            <option value="">Seleccione colegio</option>
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
                                
                                <div class="col-lg-12">
                                    <div class="hstack gap-2 justify-content-end">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                                        <button type="button" class="btn btn-primary" id="verProductosBtn">Ver productos</button>
                                    </div>
                                </div><!--end col-->

                                <script>
                                    document.getElementById('verProductosBtn').addEventListener('click', function() {
                                        var colegio = document.getElementById('id_colegio').value;
                                        var curso = document.getElementById('id_curso').value;

                                        if (colegio && curso) {
                                            window.location.href = 'ListasPorRegion.php?id_colegio=' + colegio + '&id_curso=' + curso;
                                        } else {
                                            alert('Por favor seleccione un colegio y un curso.');
                                        }
                                    });
                                </script>
                            </div><!--end row-->
                        </form>

                        <script src="js/peticiones.js"></script>

                    </div>
                </div>
            </div>
        </div> <!-- FINAL MODAL AÑADIR -->


    <?php include 'layouts/vendor-scripts.php'; ?>
    <?php include 'includes/footerCliente.php'; ?>

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

    </body>
</html>