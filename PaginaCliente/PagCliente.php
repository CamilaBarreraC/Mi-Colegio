<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Colegio</title>
    <link rel="stylesheet" href="../css/estilo.css">  
    <link rel="icon" type="icon" href="../micolegioImg/logo icono.png"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body>
    <?php include 'includes/topbarCliente.php'; ?>

    <!-- Panel para dimensiones de escritorio -->
    <div class="Panel_escritorio">
    <form>
  <select id="mySelect" name="opciones">
    <option value="">Seleccionar opción</option>
    <?php
    // Establecer conexión a la base de datos
    include("modelo\conexion_bd.php");

    // Consulta SQL para obtener las opciones
    $sql = "SELECT id, nombre FROM opciones";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<option value='" . $row["id"] . "'>" . $row["nombre"] . "</option>";
        }
    } else {
        echo "<option value=''>No hay opciones disponibles</option>";
    }

    // Cerrar conexión
    $conn->close();
    ?>
  </select>
</form>

<script>
// Función para filtrar las opciones del combobox
function filterFunction() {
  var input, filter, select, option, i;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  select = document.getElementById("mySelect");
  option = select.getElementsByTagName("option");
  for (i = 0; i < option.length; i++) {
    txtValue = option[i].textContent || option[i].innerText;
    if (txtValue.toUpperCase().indexOf(filter) > -1) {
      option[i].style.display = "";
    } else {
      option[i].style.display = "none";
    }
  }
}
</script>

<input type="text" id="myInput" onkeyup="filterFunction()" placeholder="Buscar opción..">

        
    </div>   
</body>
</html>