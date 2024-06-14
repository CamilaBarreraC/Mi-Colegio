<!DOCTYPE html>
<html lang="es">

<?php include 'layouts/session.php'; ?>
<?php include 'layouts/main.php'; ?>

<?php
    include("modelo/conexion_bd.php");

    $conn = $conexion;

    $rut_cliente = $_SESSION['rut_cliente'];

    $sql = "SELECT rut_cliente, nombre_cliente, apellido_cliente, clave,
    email, telefono, direccion, parentesco, cliente.id_comuna, nombre_comuna, 
	nombre_region
    FROM cliente 
    JOIN comuna ON cliente.id_comuna = comuna.id_comuna 
    JOIN region ON comuna.id_region = region.id_region
    WHERE cliente.rut_cliente = ". $rut_cliente;
    $result = $conn->query($sql);
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
                                        <h5 class="fs-16 mb-1"><?php echo $_SESSION['nombre_cliente'] . " " . $_SESSION['apellido_cliente']; ?></h5>
                                        <p class="text-muted mb-0"><?php echo $_SESSION['rut_cliente']; ?></p>
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
                                            <form action="update.php" method="post">
                                                <div class="row">
                                                    <?php while ($row = $result->fetch_assoc()): ?>
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="firstnameInput" class="form-label">RUT cliente</label>
                                                            <input type="number" class="form-control" name="rut_cliente" id="firstnameInput" placeholder="" value="<?php echo $row['rut_cliente']; ?>" readonly required>
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="firstnameInput" class="form-label">Contraseña</label>
                                                            <input type="password" class="form-control" name="clave" id="firstnameInput" placeholder="" value="<?php echo $row['clave']; ?>" required>
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="firstnameInput" class="form-label">Nombres</label>
                                                            <input type="text" class="form-control" name="nombre_cliente" id="firstnameInput" placeholder="Ingrese su nombre" value="<?php echo $row['nombre_cliente']; ?>" required>
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="lastnameInput" class="form-label">Apellidos</label>
                                                            <input type="text" class="form-control" name="apellido_cliente" id="lastnameInput" placeholder="Ingrese su apellido" value="<?php echo $row['apellido_cliente']; ?>" required>
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="phonenumberInput" class="form-label">Teléfono</label>
                                                            <input type="text" class="form-control" name="telefono" id="phonenumberInput" placeholder="Ingrese su teléfono" value="<?php echo $row['telefono']; ?>" required>
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="emailInput" class="form-label">Email</label>
                                                            <input type="email" class="form-control" name="email" id="emailInput" placeholder="Ingrese su email" value="<?php echo $row['email']; ?>" required>
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    
                                                    <!--end col-->
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="designationInput" class="form-label">Parentesco</label>
                                                            <select class="form-control" data-trigger name="parentesco" id="designationInput" required>
                                                                <option value="<?php echo $row['parentesco']; ?>"><?php echo $row['parentesco']; ?></option>
                                                                <option value="Padre" required>Padre</option>
                                                                <option value="Madre" required>Madre</option>
                                                                <option value="Abuelo" required>Abuelo</option>
                                                                <option value="Abuela" required>Abuela</option>
                                                                <option value="Tía" required>Tía</option>
                                                                <option value="Tío" required>Tío</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="websiteInput1" class="form-label">Dirección</label>
                                                            <input type="text" class="form-control" name="direccion" id="websiteInput1" placeholder="Ingrese su dirección" value="<?php echo $row['direccion']; ?>" required />
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-4">
                                                        <div class="mb-3">
                                                            <label for="cityInput" class="form-label">Comuna</label>
                                                            <select class="form-control" data-choices name="id_comuna" id="cityInput" required>
                                                                <option value="<?php echo $row['id_comuna']; ?>"><?php echo $row['nombre_comuna']; ?></option>
                                                                <?php
                                                                // Establecer conexión a la base de datos
                                                                include("modelo\conexion_bd.php");

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
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <?php endwhile; ?>
                                                    
                                                    
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