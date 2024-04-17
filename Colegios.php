<!DOCTYPE html>
<html lang="es">

<?php include 'layouts/session.php'; ?>
<?php include 'layouts/main.php'; ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Colegio</title>
    <link rel="icon" type="icon" href="micolegio img/logo.png"/>
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

    .boton{
        width: 286.06px; 
        height: 84.26px; 
        left: 651px; 
        top: 457px; 
        position: absolute;
        background: linear-gradient(0deg, #4200FF 0%, #4200FF 100%), linear-gradient(0deg, #4200FF 0%, #4200FF 100%), linear-gradient(0deg, #4200FF 0%, #4200FF 100%), linear-gradient(0deg, #4169E1 0%, #4169E1 100%); 
        border-radius: 8px; 
        border: 1px #001AFF solid;

        /*letra del boton*/
        position: absolute; 
        text-align: center; 
        color: white; 
        font-size: 35px; 
        font-family: Barlow; 
        font-style: italic; 
        font-weight: 800; 
        padding: 8px;
        border:2px solid #ffffff;
        outline:none;
        transition:.3s;
    }

    .boton:hover{
        background: rgb(239, 248, 255);
        color: rgb(81, 0, 255);
        border: 10px solid #6600ff;
    }
</style>

<body>
    <!-- Agrega el sidebar y topbar -->
    <?php include 'includes/sidebar.php'; ?>
    <?php include 'includes/topbar.php'; ?>

    <div class="main-content" style="background-color: rgb(226, 233, 254);width: 1440px; height: 1024px; ">
        <div class="row" style="margin-left: 400px;">
            <div class="col-lg-4 col-md-6">
                <div class="mb-3">
                    <label for="choices-single-default" class="form-label text-muted">Default</label>
                        <p class="text-muted">Set <code>data-choices</code> attribute to set a default single select.</p>
                        <select class="form-control" data-choices name="choices-single-default" id="choices-single-default">
                            <option value="">This is a placeholder</option>
                            <option value="Choice 1">Choice 1</option>
                            <option value="Choice 2">Choice 2</option>
                            <option value="Choice 3">Choice 3</option>
                        </select>
                </div>
            </div>                                     
        </div>
    </div>

    <!-- Script para el dropdown del topbar -->
    <?php include 'layouts/vendor-scripts.php'; ?>

    <!-- App js -->
    <script src="assets/js/app.js"></script>

    <?php include 'layouts/vendor-scripts.php'; ?>

    <!-- prismjs plugin -->
    <script src="assets/libs/prismjs/prism.js"></script>

</body>
</html>