<!DOCTYPE html>
<html lang="es">

<?php include 'layouts/session.php'; ?>
<?php include 'layouts/main.php'; ?>

<?php
    include("modelo/conexion_bd.php");

    $conn = $conexion;

    $sql = "SELECT rut_cliente, nombre_cliente, apellido_cliente, email, telefono, direccion, nombre_comuna FROM cliente JOIN comuna ON cliente.id_comuna = comuna.id_comuna";
    $result = $conn->query($sql);

    require_once ('controlador/crud_cliente/controlador_cliente.php');
    $obj = new ControladorCliente();

    if(isset($_GET['estado'])){

        if ($_GET['estado'] === 'invalido') {
            echo '.';
            echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>';
            echo '<script>
                    Swal.fire({
                        icon: "warning",
                        title: "RUT inválido",
                        text: "El RUT está incorrecto.",
                        showConfirmButton: false
                    });
                </script>';
        }
    }

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

                    <?php includeFileWithVariables('layouts/page-title.php', array('pagetitle' => 'Tablas', 'title' => 'Usuarios')); ?>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">

                                <div class="card-body">
                                    <div class="listjs-table" id="customerList">
                                        <div class="row g-4 mb-3">
                                            <div class="col-sm-auto">
                                                <div>
                                                    <button type="button" class="btn btn-info add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#showModal"><i class="ri-add-line align-bottom me-1"></i> Añadir usuario</button>
                                                </div>
                                            </div>
                                            <div class="col-sm">
                                                <div class="d-flex justify-content-sm-end">
                                                    <div class="search-box ms-2">
                                                        <input type="text" class="form-control search" placeholder="Buscar...">
                                                        <i class="ri-search-line search-icon"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="table-responsive table-card mt-3 mb-1">
                                            <table class="table align-middle table-nowrap" id="customerTable">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th scope="col" style="width: 50px;">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="checkAll" value="option">
                                                            </div>
                                                        </th>
                                                        <th class="sort" data-sort="customer_name">RUT</th>
                                                        <th class="sort" data-sort="email">Nombre</th>
                                                        <th class="sort" data-sort="phone">Email</th>
                                                        <th class="sort" data-sort="date">Teléfono</th>
                                                        <th class="sort" data-sort="status">Dirección</th>
                                                        <th class="sort" data-sort="action">Comuna</th>
                                                        <th class="sort" data-sort="action">Opciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody class=" form-check-all">
                                                    <!-- Dentro de <tr> se colocan todos los elementos de la fila -->
                                                    <?php while ($row = $result->fetch_assoc()): ?>
                                                        <tr>
                                                            <th scope='row'>
                                                                <div class='form-check'>
                                                                    <input class='form-check-input' type='checkbox' name='chk_child' value='option1'>
                                                                </div>
                                                            </th>
                                                                <!-- El resultado de la consulta aparece con while, 
                                                                 en los campos se pone el nombre de las columnas de la base de datos -->
                                                                <td><a href='javascript:void(0);' class='rut'> <?= $row['rut_cliente'] ?> </a></td>
                                                                <td class=''> <?= $row['nombre_cliente'] ?> <?= $row['apellido_cliente'] ?> </td>
                                                                <td class= 'email'><?= $row['email'] ?></td>
                                                                <td class='phone'> <?= $row['telefono'] ?></td>
                                                                <td class='address'>  <?= $row['direccion'] ?></td>
                                                                <td class='comuna'> <?= $row['nombre_comuna'] ?> </td>
                                                            
                                                            
                                                            <td>
                                                                <div class='d-flex gap-2'>
                                                                    <div class='edit'>
                                                                        <a href="editCliente.php?rut_cliente=<?= $row['rut_cliente'] ?>">
                                                                            <button type='button' class='btn btn-sm btn-info edit-item-btn'>Editar</button>
                                                                        </a>
                                                                    </div>
                                                                    <div class='remove'>
                                                                        <button class='btn btn-sm btn-primary remove-item-btn' data-bs-toggle='modal' data-bs-target='#deleteRecordModal' data-rut_cliente="<?= $row['rut_cliente'] ?>">Eliminar</button>
                                                                    </div>
                    
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php endwhile; ?>
                                                </tbody>
                                            </table>
                                            <div class="noresult" style="display: none">
                                                <div class="text-center">
                                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px"></lord-icon>
                                                    <h5 class="mt-2">No se han encontrado resultados</h5>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-end">
                                            <div class="pagination-wrap hstack gap-2">
                                                <a class="page-item pagination-prev disabled" href="javascrpit:void(0)"> Anterior
                                                </a>
                                                <ul class="pagination listjs-pagination mb-0"></ul>
                                                <a class="page-item pagination-next" href="javascrpit:void(0)"> Siguiente
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- end card -->
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->

                    <!-- MODAL PARA INGRESAR USUARIOS -->
                    <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-light p-3">
                                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                                </div>
                                <form action="procesar.php" method="post" class="tablelist-form" autocomplete="off">
                                    <div class="modal-body">
                                        <div class="mb-3" id="modal-id">
                                            <label for="id-rut_cliente" class="form-label">RUT</label>
                                            <input type="text" id="rut_cliente" class="form-control" placeholder="RUT" name="rut_cliente" required oninput="formatAndValidateRut(this)"/>
                                        </div>

                                        <div class="mb-3">
                                            <label for="customername-field" class="form-label">Nombre Apoderado</label>
                                            <input type="text" id="customername-field" class="form-control" placeholder="Nombre" required name="nombre_cliente" oninput="capitalizeFirstLetter(this)"/>
                                            <div class="invalid-feedback">Ingrese el nombre.</div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="customername-field" class="form-label">Apellido Apoderado</label>
                                            <input type="text" id="customername-field" class="form-control" placeholder="Apellido" required name="apellido_cliente" oninput="capitalizeFirstLetter(this)"/>
                                            <div class="invalid-feedback">Ingrese el apellido.</div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="customername-field" class="form-label">Clave</label>
                                            <input type="password" id="customername-field" class="form-control" placeholder="Clave" required name="clave"/>
                                            <div class="invalid-feedback">Ingrese la clave.</div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="email-field" class="form-label">Email</label>
                                            <input type="email" id="email-field" class="form-control" placeholder="Email" required name="email"/>
                                            <div class="invalid-feedback">Ingrese un email.</div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="phone-field" class="form-label">Teléfono</label>
                                            <input type="text" id="phone-field" class="form-control" placeholder="Teléfono" required name="telefono"/>
                                            <div class="invalid-feedback">Ingrese un teléfono.</div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="date-field" class="form-label">Dirección</label>
                                            <input type="text" id="date-field" class="form-control" placeholder="Dirección" required name="direccion" oninput="capitalizeFirstLetter(this)"/>
                                            <div class="invalid-feedback">Ingrese la dirección.</div>
                                        </div>

                                        <div>
                                            <label for="status-field" class="form-label">Parentesco</label>
                                            <select class="form-control" data-trigger name="parentesco" id="status-field" required>
                                                <option value="">Seleccione el parentesco</option>
                                                <option value="Padre" required>Padre</option>
                                                <option value="Madre" required>Madre</option>
                                                <option value="Abuelo" required>Abuelo</option>
                                                <option value="Abuela" required>Abuela</option>
                                                <option value="Tía" required>Tía</option>
                                                <option value="Tío" required>Tío</option>
                                            </select>
                                            <div class="invalid-feedback">Ingrese el parentesco.</div>
                                        </div>

                                        <div>
                                            <label for="choices-single-default" class="form-label" style="margin-top: 12px;">Comuna</label>
                                            <select class="form-control" data-choices name="id_comuna" id="choices-single-default" required>
                                                <option value="">Seleccione la comuna</option>
                                                <?php
                                                // Establecer conexión a la base de datos
                                                include("modelo\conexion_bd.php");

                                                // Consulta SQL para obtener las opciones
                                                $sql = "SELECT id_comuna, nombre_comuna FROM comuna";
                                                $resultComunas = $conexion->query($sql);

                                                // Confirma si hay resultados, ordenandolos por id 
                                                // Si no hay datos, muestra la opción de no hay registros
                                                if ($result->num_rows > 0){
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

                                        <div class="mb-3">
                                            <label for="date-field" class="form-label" style="display: none">Rol</label>
                                            <input type="text" id="date-field" class="form-control" placeholder="Cliente" required name="rol" value="Cliente" readonly style="display: none"/>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <div class="hstack gap-2 justify-content-end">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                                            <button type="submit" class="btn btn-success" id="add-btn" value="Enviar">Añadir cliente</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

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
                                            <h4>Eliminar usuario</h4>
                                            <p class="text-muted mx-4 mb-0">¿Desea eliminar este usuario?</p>
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

                    <!-- SCRIPT PARA EXTRAER EL RUT_CLIENTE Y PASARLO EN URL A ELIMINAR.PHP -->
                    <script>
                        // Agregar evento de clic a los botones "Eliminar", mediante la clase del botón
                        document.querySelectorAll('.btn').forEach(button => {
                            button.addEventListener('click', function() {
                                // Obtener el valor de rut_cliente del atributo data-rut_cliente
                                var rut_cliente = this.getAttribute('data-rut_cliente');
                                // Guardar el valor de rut_cliente en una variable
                                var rut_eliminar = rut_cliente;

                                // Mostrar el modal de eliminación
                                document.getElementById('deleteRecordModal').style.display = 'none';

                                // Después de confirmar la eliminación, oculta el modal y envía los datos a eliminar.php
                                document.getElementById('delete-record').addEventListener('click', function() {
                                    
                                    document.getElementById('deleteRecordModal').style.display = 'none';
                                    // Redirige a la página de eliminar.php, junto con el parámetro de RUT de la tabla para eliminar
                                    window.location.href = 'eliminar.php?rut_cliente=' + rut_eliminar;
                                });
                            });
                        });
                    </script>

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

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

    <script>
        function formatAndValidateRut(input) {
            let rut = input.value.trim();

            // Elimina puntos y guión existentes
            rut = rut.replace(/[.-]/g, '');

            // Divide en cuerpo y dígito verificador
            let cuerpo = rut.slice(0, -1);
            let dv = rut.slice(-1).toUpperCase();

            // Añade puntos cada tres dígitos
            cuerpo = cuerpo.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

            // Formatea el RUT completo
            let rutFormateado = `${cuerpo}-${dv}`;

            // Valida el RUT usando función isValidRut
            if (isValidRut(rut)) {
                input.value = rutFormateado;
                document.getElementById('rut-invalid-feedback').style.display = 'none';
            } else {
                document.getElementById('rut-invalid-feedback').style.display = 'block';
            }
        }

        // Función para validar el RUT
        function isValidRut(rut) {
            rut = rut.replace(/[.-]/g, '');
            if (!/^\d{1,9}-?[\dkK]$/.test(rut)) return false;
            let t = parseInt(rut.slice(0, -1), 10), m = 0, s = 1;
            while (t > 0) { s = (s + t % 10 * (9 - m++ % 6)) % 11; t = Math.floor(t / 10); }
            let v = s ? s - 1 : 'k';
            return v === rut.slice(-1).toLowerCase();
        }
    </script>

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