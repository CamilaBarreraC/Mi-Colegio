<?php
  require 'inc/conexion.php';

  $regiones = $mysqli->query("SELECT id_region, nombre_region FROM region");
?>

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
    <?php include 'includes/sidebar2.php'; ?>
    <?php include 'includes/topbarCliente.php'; ?>

    
      <div class="main-content">
        <div class="row" style="margin-left: 400px;">
          <div class="col-lg-4 col-md-6">
            <div class="mb-3">
              <label for="choices-single-default" class="form-label text-muted">Colegios</label>
              <p class="text-muted">Buscar por colegio: </p>
              <select class="form-control" data-choices name="choices-single-default" id="choices-single-default">
                <option value="">Seleccione el colegio</option>
                <?php
                // Establecer conexión a la base de datos
                include("modelo\conexion_bd.php");

                // Consulta SQL para obtener las opciones
                $sql = "SELECT id_colegio, nombre_de_colegio FROM colegio";
                $result = $conexion->query($sql);

                // Confirma si hay resultados, ordenandolos por id y colegios
                // Si no hay datos, muestra la opción de no hay registros
                if ($result->num_rows > 0){
                  while($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row["id_colegio"] . "'>" . $row["nombre_de_colegio"] . "</option>";
                  }
                }else{
                  echo "<option value=''>No hay registros de colegios</option>";
                }

                $conexion->close();
                ?>
              </select>
            </div>
          </div>                                     
        </div>
      </div>
    </div>

    <h2>Buscar por región y comuna</h2>

    <form action="" method="post">

        <p>
            <label for="region">Región:</label>
            <select name="region" id="region">
                <option value="">Seleccionar</option>
                <?php while ($row = $regiones->fetch_assoc()) { ?>
                    <option value="<?php echo $row['id_region']; ?>"><?php echo $row['nombre_region']; ?></option>
                <?php } ?>
            </select>
        </p>

        <p>
            <label for="comuna">Comuna:</label>
            <select name="comuna" id="comuna">
                <option value="">Seleccionar</option>
            </select>
        </p>

        <p>
            <label for="colegio">Colegio:</label>
            <select name="colegio" id="colegio">
                <option value="">Seleccionar</option>
            </select>
        </p>

        <p>
            <button type="submit">Guardar</button>
        </p>

    </form>

    <script src="js/peticiones.js"></script>

    <!-- Script para el dropdown del topbar -->
    <?php include 'layouts/vendor-scripts.php'; ?>

    <!-- App js -->
    <script src="assets/js/app.js"></script>

    <?php include 'layouts/vendor-scripts.php'; ?>

    <!-- prismjs plugin -->
    <script src="assets/libs/prismjs/prism.js"></script>

  </body>
</html>