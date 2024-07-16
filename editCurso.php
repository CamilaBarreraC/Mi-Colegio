<!DOCTYPE html>
<html lang="es">

<?php include 'layouts/session.php'; ?>
<?php include 'layouts/main.php'; ?>

<?php
    // Obtener el ID del colegio desde la URL
    $id_curso = $_GET['id_curso'];
    // Llamar al controlador para obtener los datos del colegio
    require_once ('controlador/crud_curso/controlador_curso.php');
    $controlador = new ControladorCurso();
    $curso = $controlador->showCurso($id_curso);
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

<style>
    @import url(https://fonts.googleapis.com/css2?family=Barlow:wght@100&display=swap);
    @import url(https://fonts.googleapis.com/css2?family=Barlow:wght@700&display=swap);
    @import url(https://fonts.googleapis.com/css2?family=Barlow:ital,wght@1,500&display=swap);
    @import url(https://fonts.googleapis.com/css2?family=Aleo&display=swap);
    @import url(https://fonts.googleapis.com/css2?family=Barlow:ital,wght@1,600&display=swap);

    #form{
        font-family: Barlow; 
        font-weight: 800;
    }
</style>

<body>
    <!-- Agrega el sidebar y topbar -->
    <?php include 'includes/sidebar.php'; ?>
    <?php include 'includes/topbar.php'; ?>

    <!-- Begin page -->
    <div id="layout-wrapper">
        <!-- PÁGINA PARA EDITAR DATOS DEL PEDIDO -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <div id="container" tabindex="-1" >
                        <div class="">
                            <h5 id="exampleModalgridLabel" style="color: rgba(105, 94, 239, 1);font-size:30px; margin-bottom: 20px">ID Curso: <?= $id_curso ?></h5>
                        </div>
                        <div class="">
                            <?php if ($curso): ?>
                            <form action="updateCurso.php" method="post">
                                <div class="row g-3">
                                    <div class='col-xxl-6' style="display: none;">
                                        <div>    
                                            <label for='id_curso' class='form-label' >ID curso</label>
                                            <input type='text' class='form-control' name="id_curso" id="id_curso" value="<?= $curso['id_curso'] ?>" readonly>                           
                                        </div>
                                    </div>
                                    
                                    <div class="col-xxl-6">
                                        <div>
                                            <label for="choices-single-default" class="form-label" style="margin-top: 0px;">Nombre curso</label>
                                            <select class="form-control" data-choices name="nombre_curso" id="choices-single-default" required>
                                                <option value="<?= $curso['nombre_curso'] ?>"><?= $curso['nombre_curso'] ?></option>
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
                                    </div><!--end col-->
                                    <div class="col-xxl-6">
                                        <div>
                                            <label for="cantidad_alumnos" class="form-label">Cantidad de alumnos</label>
                                            <select class="form-control" data-trigger name="cantidad_alumnos" id="status-field" required>
                                                <option value="<?= $curso['cantidad_alumnos'] ?>"><?= $curso['cantidad_alumnos'] ?></option>
                                                <option value="25" required>25</option>
                                                <option value="30" required>30</option>
                                                <option value="35" required>35</option>
                                                <option value="40" required>40</option>
                                            </select>
                                        </div>
                                    </div><!--end col-->

                                    <div class="col-xxl-6">
                                        <div>
                                            <label for="choices-single-default" class="form-label">Colegio</label>
                                            <select class="form-control" data-choices name="id_colegio" id="choices-single-default" required>
                                                <option value="<?= $curso['id_colegio'] ?>"><?= $curso['nombre_de_colegio'] ?></option>
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

                                    <div class="col-lg-12">
                                        <div class="hstack gap-2 justify-content-end">
                                            <a href="Cursos.php">
                                                <button type="button" class="btn btn-light">Volver</button>
                                            </a>
                                            <button type="submit" class="btn btn-primary" value="Actualizar">Actualizar</button>
                                        </div>
                                    </div><!--end col-->
                                </div><!--end row-->
                            </form>
                            <?php endif; ?>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>

    <?php include 'layouts/vendor-scripts.php'; ?>
    <!-- prismjs plugin -->
    <script src="assets/libs/prismjs/prism.js"></script>
    <script src="assets/libs/list.js/list.min.js"></script>
    <script src="assets/libs/list.pagination.js/list.pagination.min.js"></script>

    <!-- listjs init -->
    <script src="assets/js/pages/listjs.init.js"></script>

    <!-- Sweet Alerts js -->
    <script src="assets/libs/sweetalert2/sweetalert2.min.js"></script>

    <!-- App js -->
    <script src="assets/js/app.js"></script>
</body>
</html>