<!DOCTYPE html>
<html lang="es">

<?php include 'layouts/session.php'; ?>
<?php include 'layouts/main.php'; ?>

<?php 

    include("modelo/conexion_bd.php");

    $conn = $conexion;

    $sqlProd = "SELECT *
    FROM productos
    limit 9";
    $resultProd = $conn->query($sqlProd);

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Colegio</title>
    <link rel="icon" type="icon" href="micolegioImg/logo icono.png"/>

    <link rel="stylesheet" href="css/estiloPagCliente.css">  

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php includeFileWithVariables('layouts/title-meta.php', array('title' => 'Dashboard')); ?>

    <!-- jsvectormap css -->
    <link href="assets/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css" />

    <!--Swiper slider css-->
    <link href="assets/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css" />

    <?php include 'layouts/head-css.php'; ?>
</head>

<style>
    @import url(https://fonts.googleapis.com/css2?family=Arsenal:ital,wght@0,400;0,700;1,400;1,700&family=Barlow:ital,wght@1,500&display=swap);
    @import url(https://fonts.googleapis.com/css2?family=Barlow:wght@100&display=swap);
    @import url(https://fonts.googleapis.com/css2?family=Barlow:wght@700&display=swap);
    @import url(https://fonts.googleapis.com/css2?family=Barlow:ital,wght@1,500&display=swap);
    @import url(https://fonts.googleapis.com/css2?family=Aleo&display=swap);
    @import url(https://fonts.googleapis.com/css2?family=Barlow:ital,wght@1,600&display=swap);

    .img_sobre{
        background-color: azure;
        width: 90%;
        height: auto;
        margin: 102px 49px 0 50px;
        background-size: cover;
        border-radius: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 20px;
        margin-bottom: 50px;
    }

    .titulo_sobre{
        width: 100%;
        font-family: Arsenal;
        font-size: 70px;
        font-weight: bold;
        font-style: italic;
        color: blueviolet;
        margin-bottom: 50px;
    }

    .texto_sobre{
        width: 300px;
        margin: 20px;
        font-family: Arsenal;
        font-size: 20px;
        font-style: italic;
        color: #4d0099;
    }

    .icono_mision,
    .icono_vision,
    .icono_valores {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin: 0 30px;
    }

    @media (max-width: 768px) {
        .texto_productos, .titulo_sobre, .texto_sobre {
            font-size: 24px;
        }
        .btn_productos, .btn_sobre {
            width: 100%;
        }
        .icono_mision,
        .icono_vision,
        .icono_valores {
            margin: 0 15px;
        }
    }

    @media (max-width: 480px) {
        .texto_productos, .titulo_sobre {
            font-size: 18px;
        }
        .texto_sobre {
            font-size: 16px;
        }
    }

</style>

<body style="background-color: white;">

    <?php include 'includes/topbar.php'; ?>

    <div class="container_productos" style="display: grid; place-items: center; background-color: white; width: 100%;">
        <div class="img_sobre" style="width: 90%;"> 
            <h1 class="titulo_sobre" style="width: 100%;">Sobre nosotros</h1>

            <div style="display: flex; justify-content: center; flex-wrap: wrap;">
                <div class="icono_mision">
                    <img src="micolegioimg/mision.png" style="width: 250px; height: 250px;">
                    <p class="texto_sobre"><strong style="font-size: 30px; color: blueviolet;">Nuestra misión:</strong> <br>
                    Trabajamos arduamente para ofrecer una experiencia de compra fácil, permitiendo a las familias acceder a listas de útiles escolares directamente desde la comodidad de sus hogares.</p>
                </div>
                <div class="icono_vision">
                    <img src="micolegioimg/vision.png" style="width: 250px; height: 250px;">
                    <p class="texto_sobre"><strong style="font-size: 30px; color: blueviolet;">Nuestra visión:</strong> <br>
                    Convertirnos en la plataforma líder en Chile para la compra de útiles escolares, promoviendo una educación inclusiva y de calidad.</p>
                </div>
                <div class="icono_valores">
                    <img src="micolegioimg/valores.png" style="width: 250px; height: 250px;">
                    <p class="texto_sobre"><strong style="font-size: 30px; color: blueviolet;">Nuestros valores:</strong> <br>
                    Nuestros valores son el compromiso, innovación, excelencia y colaboración.</p>
                </div>
            </div>
        </div>
    </div>

    <script src="js/app.js"></script>

    <?php include 'includes/topbarCliente.php'; ?>
    <?php include 'includes/footerCliente.php'; ?>

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

    <!-- swiper.init js -->
    <script src="assets/js/pages/swiper.init.js"></script>

    <!-- prismjs plugin -->
    <script src="assets/libs/prismjs/prism.js"></script>

</body>
</html>
