<!DOCTYPE html>
<html lang="es">

<?php include 'layouts/session.php'; ?>
<?php include 'layouts/main.php'; ?>

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
    @import url('https://fonts.googleapis.com/css2?family=Arsenal:ital,wght@0,400;0,700;1,400;1,700&family=Barlow:ital,wght@1,500&display=swap');
    @import url(https://fonts.googleapis.com/css2?family=Barlow:wght@100&display=swap);
    @import url(https://fonts.googleapis.com/css2?family=Barlow:wght@700&display=swap);
    @import url(https://fonts.googleapis.com/css2?family=Barlow:ital,wght@1,500&display=swap);
    @import url(https://fonts.googleapis.com/css2?family=Aleo&display=swap);
    @import url(https://fonts.googleapis.com/css2?family=Barlow:ital,wght@1,600&display=swap);

    .img_productos{
        background-image: url(micolegioImg/fondoProd.png) ;
        width:90%;
        height: 367px;
        flex-grow: 0;
        margin: 102px 49px 0 50px;
        padding: 59.5px 4.5px 51.9px 567.2px;
        background-size: cover;
        border-radius: 50px;
    }

    .texto_productos{
        width: 80%;
        height: 165.1px;
        flex-grow: 0;
        margin: 0 0 21.8px;
        -webkit-backdrop-filter: blur(4px);
        backdrop-filter: blur(4px);
        font-family: Arsenal;
        font-size: 70px;
        font-weight: bold;
        font-stretch: normal;
        font-style: italic;
        line-height: normal;
        letter-spacing: normal;
        text-align: center;
        color: #fff;
    }

    .btn_productos{
        width: 35%;
        height: 68.7px;
        flex-grow: 0;
        margin: 21.8px 226.5px 0 225.6px;
        border-radius: 30px;
        background-color: #fff;
        padding-top: 10px;
        border-color: white;
    }

    .txt_btn_productos{
        width: 100%;
        height: 68.7px;
        flex-grow: 0;
        font-family: Arsenal;
        font-size: 30px;
        font-weight: bold;
        font-stretch: normal;
        font-style: italic;
        line-height: normal;
        letter-spacing: normal;
        text-align: center;
        color: #6100ff;
    }

</style>

<body style="background-color: white;">

    <?php include 'includes/topbar.php'; ?>

    <div class="slider">


        <div class="list">

            <div class="item">
                <img src="./micolegioImg/fondislider.png" alt="">

                <div class="content" style="margin-top: 100px;">
                    <div class="title" style="color: #5647ff;">¡Directo a tu hogar! <br> </div>
                    <div class="type" style="color: #5e2cca;font-size: 40px;
                    margin-top: 40px;">Asegura tu lista escolar 2024</div>
                    
                    <div class="button">
                        <a href="ListasColegioPagCliente.php">
                            <button style="border-radius: 30px;background-color: #7000FF;color: white;
                            font-weight: bold; font-stretch: normal; font-style: italic;
                            line-height: normal; letter-spacing: normal; text-align: center; font-size: 20px;
                            width: 180%;height: 130%; margin-top: 20px;">¡Reserva tu lista!</button>
                        </a>
                    </div>
                </div>
            </div>

            <div class="item">
                <img src="./micolegioImg/fondo slider.PNG" alt="" >

                <div class="content" style="margin-top: 100px;">
                    <div class="title" style="color: #6229BF; text-shadow:none">¡Ahorra tiempo!  <br> </div>
                    <div class="type" style="color: #5647ff;font-size: 25px;
                    margin-top: 20px; text-shadow:none">Evita la caótica búsqueda de los útiles escolares.
                    <br>Aquí encontrarás todas las listas escolares del país, 
                    <br>junto con los mejores precios 🤑</div>
                    
                    <div class="button">
                        <a href="ListasColegioPagCliente.php">
                            <button style="border-radius: 30px;background-color: #6229BF;color: white;
                            font-weight: bold; font-stretch: normal; font-style: italic;
                            line-height: normal; letter-spacing: normal; text-align: center; font-size: 20px;
                            width: 180%;height: 130%; ">Busca tu colegio</button>
                        </a>                      
                    </div>
                </div>
            </div>

        </div>

        <div class="thumbnail">

            <div class="item">
                <img src="./micolegioImg/fondi.PNG" alt="">
            </div>
            <div class="item">
                <img src="./micolegioImg/fondo slider.PNG" alt="">
            </div>            

        </div>

        <div class="nextPrevArrows">
            <button class="prev" style="background-color: #7c49e8;"> < </button>
            <button class="next" style="background-color: #7c49e8;"> > </button>
        </div>

    </div>

    <div class="container_productos" style="display: grid;place-items: center;background-color: white; width:100%">
        <div class="img_productos" style="width: 90%;"> 
            <h1 class="texto_productos" style="width: 100%;">¡Conoce los productos disponibles!</h1>

            <a href="ProductosPagCliente.php">
                <button class="btn_productos">
                    <p class="txt_btn_productos">Ver productos</p>
                </button>
            </a>
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

    </body>
</html>