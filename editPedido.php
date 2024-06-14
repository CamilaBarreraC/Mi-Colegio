<!DOCTYPE html>
<html lang="es">

<?php include 'layouts/session.php'; ?>
<?php include 'layouts/main.php'; ?>

<?php
    // Obtener el ID del pedido desde la URL
    $id_pedido = $_GET['id_pedido'];
    // Llamar al controlador para obtener los datos del pedido
    require_once ('controlador/crud_pedido/controlador_pedido.php');
    $controlador = new ControladorPedido();
    $pedido = $controlador->showPedido($id_pedido);
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
                            <h5 id="exampleModalgridLabel" style="color: rgba(105, 94, 239, 1);font-size:30px; margin-bottom: 20px">ID Pedido: <?= $id_pedido ?></h5>
                        </div>
                        <div class="">
                            <?php if ($pedido): ?>
                            <form action="updatePedido.php" method="post">
                                <div class="row g-3">
                                    <div class='col-xxl-6'>
                                        <div>    
                                            <label for='id_pedido' class='form-label' >ID pedido</label>
                                            <input type='text' class='form-control' name="id_pedido" id="id_pedido" value="<?= $pedido['id_pedido'] ?>" readonly>                           
                                        </div>
                                    </div>
                                    
                                    <div class="col-xxl-6">
                                        <div>
                                            <!-- SELECT PARA MOSTRAR TODOS LOS RUTS DISPONIBLES -->
                                            <label for="choices-single-default" class="form-label" style="margin-top: 0px;">RUT Cliente</label>
                                            <select class="form-control" data-choices name="rut_cliente" id="choices-single-default" required>
                                                <option value="<?= $pedido['rut_cliente'] ?>"><?= $pedido['rut_cliente'] ?></option>
                                                <?php
                                                // Establecer conexión a la base de datos
                                                include("modelo\conexion_bd.php");

                                                // Consulta SQL para obtener las opciones
                                                $sql = "SELECT rut_cliente, nombre_cliente FROM cliente";
                                                $resultClientes = $conexion->query($sql);

                                                // Confirma si hay resultados, ordenandolos por id 
                                                // Si no hay datos, muestra la opción de no hay registros
                                                if ($result->num_rows > 0){
                                                    while($row = $resultClientes->fetch_assoc()) {
                                                        echo "<option value='" . $row["rut_cliente"] . "'> RUT de: " . $row["nombre_cliente"], $row["rut_cliente"] . "</option>";
                                                    }
                                                }else{
                                                    echo "<option value=''>No hay registros de RUT</option>";
                                                }

                                                $conexion->close();
                                                ?>
                                            </select>   
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-xxl-6">
                                        <div>
                                        <label for="choices-single-default" class="form-label" style="margin-top: 0px;">Listas</label>
                                        <select class="form-control" data-choices name="id_lista_2" id="choices-single-default" required>
                                            <option value="<?= $pedido["id_lista_2"] ?>">Lista de RUT: <?= $pedido["rut_cliente"] ?></option>
                                            <?php
                                            // Establecer conexión a la base de datos
                                            include("modelo\conexion_bd.php");

                                            // Consulta SQL para obtener las opciones
                                            $sql = "SELECT id_lista_2, rut_cliente FROM lista_2";
                                            $resultListas = $conexion->query($sql);

                                            // Confirma si hay resultados, ordenandolos por id 
                                            // Si no hay datos, muestra la opción de no hay registros
                                            if ($result->num_rows > 0){
                                                while($row = $resultListas->fetch_assoc()) {
                                                    echo "<option value='" . $row["id_lista_2"] . "'> Lista de RUT: " . $row["rut_cliente"] . "</option>";
                                                }
                                            }else{
                                                echo "<option value=''>No hay registros de listas</option>";
                                            }

                                            $conexion->close();
                                            ?>
                                        </select>
                                        </div>
                                    </div><!--end col-->

                                    <div class="col-xxl-6">
                                        <div>
                                            <label for="precio_total" class="form-label">Precio total</label>
                                            <input type="text" class="form-control" id="precio_total" name="precio_total" required value="<?= $pedido['precio_total'] ?>">
                                            <div class="invalid-feedback">Ingrese el precio total.</div>
                                        </div>
                                    </div><!--end col-->

                                    <div class="col-xxl-6">
                                        <div>
                                        <label for="choices-single-default" class="form-label" style="margin-top: 0px;">Medio de pago</label>
                                        <select class="form-control" data-choices name="id_medio_pago" id="choices-single-default" required>
                                        <option value="<?= $pedido["id_medio_pago"] ?>">Lista de RUT: <?= $pedido["id_medio_pago"] ?></option>
                                            <?php
                                            // Establecer conexión a la base de datos
                                            include("modelo\conexion_bd.php");

                                            // Consulta SQL para obtener las opciones
                                            $sql = "SELECT id_medio_pago, nombre_medio_pago FROM medios_de_pago";
                                            $resultPagos = $conexion->query($sql);

                                            // Confirma si hay resultados, ordenandolos por id 
                                            // Si no hay datos, muestra la opción de no hay registros
                                            if ($result->num_rows > 0){
                                                while($row = $resultPagos->fetch_assoc()) {
                                                    echo "<option value='" . $row["id_medio_pago"] . "'>" . $row["nombre_medio_pago"] . "</option>";
                                                }
                                            }else{
                                                echo "<option value=''>No hay registros de medios de pago</option>";
                                            }

                                            $conexion->close();
                                            ?>
                                        </select>
                                        </div>
                                    </div><!--end col-->

                                    <div class="col-xxl-6">
                                        <div>
                                            <label for="estado" class="form-label">Estado</label>
                                            <select class="form-control" data-trigger name="estado" id="estado" required >
                                                <div class="invalid-feedback">Ingrese el estado.</div>
                                                <option value="<?= $pedido['estado'] ?>"><?= $pedido['estado'] ?></option>
                                                <option value="Finalizado">Finalizado</option>
                                                <option value="Pendiente">Pendiente</option>
                                            </select>
                                        </div>
                                    </div><!--end col-->

                                    <div class="col-lg-12">
                                        <div class="hstack gap-2 justify-content-end">
                                            <a href="Pedidos.php">
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