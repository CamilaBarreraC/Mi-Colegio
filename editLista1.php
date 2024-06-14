<!DOCTYPE html>
<html lang="es">

<?php include 'layouts/session.php'; ?>
<?php include 'layouts/main.php'; ?>

<?php
    // Obtener el ID del colegio desde la URL
    $id_lista_1 = $_GET['id_lista_1'];
    // Llamar al controlador para obtener los datos del colegio
    require_once ('controlador/crud_lista1/controlador_lista1.php');
    $controlador = new ControladorLista1();
    $lista1 = $controlador->showLista1($id_lista_1);
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
                            <h5 id="exampleModalgridLabel" style="color: rgba(105, 94, 239, 1);font-size:30px; margin-bottom: 20px">ID Lista: <?= $id_lista_1 ?></h5>
                        </div>
                        <div class="">
                            <?php if ($lista1): ?>
                            <form action="updateLista1.php" method="post">
                                <div class="row g-3">
                                    <div class='col-xxl-6'>
                                        <div>    
                                            <label for='id_lista_1' class='form-label' >ID lista</label>
                                            <input type='text' class='form-control' name="id_lista_1" id="id_lista_1" value="<?= $lista1['id_lista_1'] ?>" readonly>                           
                                        </div>
                                    </div>

                                    <div class="col-xxl-6">
                                        <div>
                                            <label for="id_colegio" class="form-label">Colegio</label>
                                            <select class="form-control" name="id_colegio" id="id_colegio" required>
                                                <option value="<?= $lista1['id_colegio'] ?>"><?= $lista1['nombre_de_colegio'] ?></option>
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
                                            <select class="form-control" name="id_curso" id="id_curso" required onchange="updateCursoName()">
                                                <option value="<?= $lista1['id_curso'] ?>"><?= $lista1['nombre_curso'] ?></option>
                                            </select>

                                            <!-- Aquí se pone el nombre del curso seleccionado -->
                                            <!-- Con display:none para no aparecer en la interfaz -->
                                            <span id="curso_nombre" style="display: none;"></span> 
                                            <input type="hidden" name="ingresoNombreCurso" id="ingresoNombreCurso"> 
                                            <!-- input oculto para almacenar el nombre y enviarlo a procesar -->

                                            <script>
                                                function updateCursoName() {
                                                    // Script para extrar los datos del select y enviarlo al span y el input oculto
                                                    var select = document.getElementById("id_curso");
                                                    var curso_nombre = document.getElementById("curso_nombre");
                                                    var ingresoNombreCurso = document.getElementById("ingresoNombreCurso");
                                                    var selected_option = select.options[select.selectedIndex];
                                                    curso_nombre.textContent = selected_option.textContent;
                                                    ingresoNombreCurso.value = selected_option.textContent; 
                                                }
                                                
                                            </script>
                                        </div>
                                    </div><!--end col-->
                                    
                                    <div class="col-lg-12">
                                        <div class="hstack gap-2 justify-content-end">
                                            <a href="Listas1.php">
                                                <button type="button" class="btn btn-light">Volver</button>
                                            </a>
                                            <button type="submit" class="btn btn-primary" value="Actualizar">Actualizar</button>
                                        </div>
                                    </div><!--end col-->
                                </div><!--end row-->
                            </form>
                            <script src="js/peticionesCurso.js"></script>
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