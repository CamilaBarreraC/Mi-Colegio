<!DOCTYPE html>
<html lang="es">

<?php include 'layouts/session.php'; ?>
<?php include 'layouts/main.php'; ?>

<?php
    // Obtener el ID del usuario desde la URL
    $rut_cliente = $_GET['rut_cliente'];
    // Llamar al controlador para obtener los datos del usuario
    require_once ('controlador/crud_cliente/controlador_cliente.php');
    $controlador = new ControladorCliente();
    $usuario = $controlador->show($rut_cliente);
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
        <!-- PÁGINA PARA EDITAR DATOS DEL USUARIO -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <div id="container" tabindex="-1" >
                        <div class="">
                            <h5 id="exampleModalgridLabel" style="color: rgba(105, 94, 239, 1);font-size:30px; margin-bottom: 20px">Usuario RUT: <?= $rut_cliente ?></h5>
                        </div>
                        <div class="">
                            <?php if ($usuario): ?>
                            <form action="update.php" method="post">
                                <div class="row g-3">
                                    <div class='col-xxl-6' style="display: none;">
                                        <div style="display: none;">    
                                            <label for='rut_cliente' class='form-label' >RUT cliente</label>
                                            <input type='text' class='form-control' name="rut_cliente" id="rut_cliente" value="<?= $usuario['rut_cliente'] ?>" readonly>
                                            <div class="invalid-feedback">Ingrese el RUT.</div>                                
                                        </div>
                                    </div>
                                    <div class="col-xxl-6">
                                        <div>
                                            <label for="nombre_cliente" class="form-label">Nombre cliente</label>
                                            <input type="text" class="form-control" id="nombre_cliente" name="nombre_cliente" required value="<?= $usuario['nombre_cliente'] ?>">
                                            <div class="invalid-feedback">Ingrese el nombre.</div>
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-xxl-6">
                                        <div>
                                            <label for="apellido_cliente" class="form-label">Apellido cliente</label>
                                            <input type="text" class="form-control" id="apellido_cliente" name="apellido_cliente" required value="<?= $usuario['apellido_cliente'] ?>">
                                            <div class="invalid-feedback">Ingrese el apellido.</div>
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-xxl-6">
                                        <div>
                                            <label for="clave" class="form-label">Clave</label>
                                            <input type="password" class="form-control" id="clave" name="clave" required value="<?= $usuario['clave'] ?>">
                                            <div class="invalid-feedback">Ingrese la clave.</div>
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-xxl-6">
                                        <div>
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" required value="<?= $usuario['email'] ?>">
                                            <div class="invalid-feedback">Ingrese el email.</div>
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-xxl-6">
                                        <div>
                                            <label for="telefono" class="form-label">Teléfono</label>
                                            <input type="text" class="form-control" id="telefono" name="telefono" required value="<?= $usuario['telefono'] ?>">
                                            <div class="invalid-feedback">Ingrese el teléfono.</div>
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-xxl-6">
                                        <div>
                                            <label for="direccion" class="form-label">Dirección</label>
                                            <input type="text" class="form-control" id="direccion" name="direccion" required value="<?= $usuario['direccion'] ?>">
                                            <div class="invalid-feedback">Ingrese la dirección.</div>
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-xxl-6">
                                        <div>
                                            <!-- SELECT PARA MOSTRAR TODAS LAS REGIONES -->
                                            <label for="choices-single-default" class="form-label">Comuna</label>
                                            <select class="form-control" data-choices name="id_comuna" id="choices-single-default" required>
                                                <option value="<?= $usuario['id_comuna'] ?>"><?= $usuario['nombre_comuna'] ?></option>
                                                <?php
                                                // Establecer conexión a la base de datos
                                                include("modelo/conexion_bd.php");

                                                // Consulta SQL para obtener las opciones
                                                $sql = "SELECT id_comuna, nombre_comuna FROM comuna";
                                                $resultComunas = $conexion->query($sql);

                                                // Confirma si hay resultados, ordenandolos por id 
                                                // Si no hay datos, muestra la opción de no hay registros
                                                if ($resultComunas->num_rows > 0){
                                                    while($row = $resultComunas->fetch_assoc()) {
                                                        echo "<option value='" . $row["id_comuna"] . "'>" . $row["nombre_comuna"] . "</option>";
                                                    }
                                                }else{
                                                    echo "<option value=''>No hay registros de comunas</option>";
                                                }

                                                $conexion->close();
                                                ?>
                                            </select>
                                            <div class="invalid-feedback">Ingrese la comuna.</div>
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-xxl-6">
                                        <div>
                                            <label for="parentesco" class="form-label">Parentesco</label>
                                            <select class="form-control" data-trigger name="parentesco" id="parentesco" required >
                                                <div class="invalid-feedback">Ingrese el parentesco.</div>
                                                <option value="<?= $usuario['parentesco'] ?>"><?= $usuario['parentesco'] ?></option>
                                                <option value="Padre">Padre</option>
                                                <option value="Madre">Madre</option>
                                                <option value="Abuelo">Abuelo</option>
                                                <option value="Abuela">Abuela</option>
                                                <option value="Tía">Tía</option>
                                                <option value="Tío">Tío</option>
                                            </select>
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-lg-12">
                                        <div class="hstack gap-2 justify-content-end">
                                            <a href="Usuarios.php">
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