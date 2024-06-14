<!DOCTYPE html>
<html lang="es">

<?php include 'layouts/session.php'; ?>
<?php include 'layouts/main.php'; ?>

<?php
    include("modelo/conexion_bd.php");

    $conn = $conexion;

    $por_pagina=9;

    if(isset($_GET['pagina'])){
        $pagina=$_GET['pagina'];
    }else{
        $pagina=1;
    }

    $empieza = ($pagina-1) * $por_pagina;

    $query = "SELECT id_producto, nombre_producto, productos.id_categoria, precio,
    dir, nombre_categoria
    FROM productos 
    JOIN categoria ON productos.id_categoria = categoria.id_categoria";

    $categoria = "";

    // Agrega WHERE según los valores de los selects con filtros
    if (empty($_POST['precio'])) {
        $query = "SELECT id_producto, nombre_producto, productos.id_categoria, precio,
        dir, nombre_categoria
        FROM productos 
        JOIN categoria ON productos.id_categoria = categoria.id_categoria";
    }else{
        $categoria = $_POST['categoria'];
        $query .= " WHERE productos.id_categoria = $categoria";
        $precioOrden = $_POST['precio'];
        $query .= " ORDER BY precio $precioOrden";
    }

    $query .= " LIMIT $empieza, $por_pagina";

    $resultado = mysqli_query($conn, $query);

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
        background-image: url(micolegioImg/fondoPagProductos.png) ;
        width:100%;
        height: 300px;
        flex-grow: 0;
        margin: 102px 49px 0 50px;
        padding: 59.5px 4.5px 51.9px 567.2px;
        background-size: cover;
        border-radius: 50px;
    }

    .element-item:hover{
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.20);
    }

    .element-item:hover .gallery-img{
        transform: scale(1.2);
    }

</style>

<body style="background-color:azure;">

    <?php include 'includes/topbarCliente.php'; ?>
    <?php include 'includes/sidebar2.php'; ?>

    <div class="container_productos" style="display: grid;place-items: center; width:100%">
        <div class="img_fondo_productos" style="width: 90%;"> </div>
    </div>

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-3 col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex mb-3">
                                <div class="flex-grow-1">
                                    <form method="post">
                                        <h5 class="fs-16">Filtros</h5>
                                    </form>
                                </div>

                            </div>

                        </div>

                        <div class="accordion accordion-flush filter-accordion">

                            <div class="accordion-item">

                                <div id="flush-collapseBrands" class="accordion-collapse collapse show" aria-labelledby="flush-headingBrands">
                                    <div class="accordion-body text-body pt-0">

                                        <h5 class="fs-16" style="margin-top:15px">Categorías</h5>
                                       
                                        <div class="d-flex flex-column gap-2 mt-3 filter-check">
                                            <form method="post">
                                                <select class="form-control" data-choices name="categoria" id="categoria" required>
                                                    <option value="">Seleccione categoría</option>
                                                    <?php
                                                        // Consulta SQL para obtener las opciones
                                                        $sql = "SELECT id_categoria, nombre_categoria FROM categoria";
                                                        $resultCat = $conn->query($sql);

                                                        // Confirma si hay resultados, ordenandolos por id 
                                                        // Si no hay datos, muestra la opción de no hay registros
                                                        if ($resultCat->num_rows > 0){
                                                            while($row = $resultCat->fetch_assoc()) {
                                                                echo "<option value='" . $row["id_categoria"] . "'>" . $row["nombre_categoria"] . "</option>";
                                                            }
                                                        }else{
                                                            echo "<option value=''>No hay registros de categorías</option>";
                                                        }
                                                    ?>
                                                </select>

                                                <div class="card-body border-bottom">
                                                    <div>
                                                        <h5 class="fs-16" style="margin-top:10px; margin-bottom:15px">Precio</h5>
                                                        <select class="form-control" data-choices name="precio" id="precio" style="width: 100%;" required>
                                                            <option value="">Seleccione</option>
                                                            <option value="DESC">De mayor a menor</option>
                                                            <option value="ASC">De menor a mayor</option>
                                                        </select>

                                                        <div class="card-body border-bottom">
                                                            <div style="display: flex;align-items: center;flex-direction: column">
                                                                <button type="submit" class="btn rounded-pill btn-primary waves-effect waves-light" 
                                                                style="font-size: 15px;width:70%" name="buscar">Buscar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form> 
                                            <!-- Se redirige a la misma página sin los parámetros de categoría -->
                                            <a href="ProductosPagCliente.php" style="align-items: center;display:flex; flex-direction:column">Limpiar filtros</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end accordion-item -->
                            
                        </div>
                    </div>
                    <!-- end card -->
                </div>
                <!-- end col -->

                <div class="col-xl-9 col-lg-8">
                    <div>
                        <div class="card">
                            
                            <div class="card-body">
                                <form method="post">
                                    <div class="row gallery-wrapper">
                                        <!-- INICIO CARD PARA PRODUCTOS -->
                                        <?php while ($fila = mysqli_fetch_assoc($resultado)): ?>
                                        <div class="element-item col-xxl-3 col-xl-4 col-sm-6 project designing development" data-category="designing development" style="margin-left:80px;" id="resultado_busqueda">
                                            <div class="gallery-box card">
                                                <div class="gallery-container">
                                                    <a class="image-popup" href="image/<?php echo $fila['dir']; ?>" title="">
                                                        <img class="gallery-img img-fluid mx-auto" style="width: 100%; height:200px" src="<?php echo $fila['dir']; ?>" alt="" />
                                                        <div class="gallery-overlay">
                                                        </div>
                                                    </a>
                                                </div> 

                                                <div class="box-content" >
                                                    <div class="d-flex align-items-center mt-1" style="margin-bottom: 10px;">
                                                        <div class="flex-grow-1 text-muted" style="font-size: 18px;"><?php echo $fila['nombre_producto']; ?></div>
                                                        <div class="flex-shrink-0">
                                                            <div class="d-flex gap-3">
                                                                <button type="button" class="btn btn-sm fs-12 btn-link text-body text-decoration-none px-0">
                                                                    <h5><i class=" bx bx-dollar"></i><?php echo $fila['precio']; ?></h2>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div style="display: flex; flex-direction: column; align-items: center;">
                                                        <button type="button" class="btn btn-primary waves-effect waves-light" style="width: 300px;font-size:18px"><i class="bx bxs-cart"></i> Añadir al carro</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end col -->
                                        <?php endwhile; ?>
                                    </div>                                                         
                                </form>

                                <?php
                                    // Agrega WHERE si el select no está vacío
                                    if (empty($_POST['precio'])) {
                                        // Si está vacío el select de filtro, solo muestra todos los productos con 
                                        // límite de 9 por cada paginación
                                        $query = "SELECT id_producto, nombre_producto, productos.id_categoria, precio,
                                        dir, nombre_categoria
                                        FROM productos 
                                        JOIN categoria ON productos.id_categoria = categoria.id_categoria ";

                                        $resultado = mysqli_query($conn, $query); 

                                    }else{
                                        //Si el select para categoría no está vacío, ejecuta la sentencia
                                        // hecha al principio, y cuenta la cantidad de resultados en la BD
                                        // y los divide por 9, que son el límite de cada paginación
                                        $resultado = mysqli_query($conn, $query);
                                    }

                                    // Calcula cuántos resultado se obtuvieron en la consulta
                                    $total_registros=mysqli_num_rows($resultado);
                                    // Divide los resultados obtenidos por 9
                                    // Para así obtener el máximo de la paginación, dependiendo del resultado
                                    $total_paginas = ceil($total_registros/$por_pagina);

                                    echo "<nav aria-label='Page navigation example'>";
                                    echo "<ul class='pagination justify-content-center' style='margin-top:50px;'>";

                                    echo "<li class='page-item " . ($pagina <= 1 ? 'disabled' : '') . "'><a class='page-link' href='ProductosPagCliente.php?pagina=".($pagina - 1)."'>Anterior</a></li>";

                                    for ($i = 1; $i <= $total_paginas; $i++) {
                                        echo "<li class='page-item'><a class='page-link' href='ProductosPagCliente.php?pagina=" . $i . "'>" . $i . "</a></li>";
                                    }

                                    echo "<li class='page-item'><a class='page-link' href='ProductosPagCliente.php?pagina=" . ($pagina + 1) . "'>Siguiente</a></li>";

                                    echo "</ul>";
                                    echo "</nav>";
                                ?>

                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->

        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

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

    </body>
</html>