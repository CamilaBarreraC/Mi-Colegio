<!DOCTYPE html>

<?php

if(isset($_GET['invalido'])){

    if ($_GET['invalido'] === 'true') {
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

<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Colegio</title>
    <link rel="stylesheet" href="css/estilo_login.css">  
    <link rel="icon" type="icon" href="micolegioImg/logo icono.png"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<style>
    @import url(https://fonts.googleapis.com/css2?family=Barlow:wght@100&display=swap);
    @import url(https://fonts.googleapis.com/css2?family=Barlow:wght@700&display=swap);
    @import url(https://fonts.googleapis.com/css2?family=Barlow:ital,wght@1,500&display=swap);
    @import url(https://fonts.googleapis.com/css2?family=Aleo&display=swap);
    @import url(https://fonts.googleapis.com/css2?family=Barlow:ital,wght@1,600&display=swap);

    *{
        font-family: Barlow;
        font-weight: 500;
        font-stretch: normal;
        font-style: italic;
    }

    input{
        font-style: normal;
        font-weight: 600;
    }

    .selects{
        font-style: normal;
        background: #eee; 
        border: none; 
        border-radius: 50px; 
        padding: 12px 15px;
    }
</style>

<body>
<!-- Animated Wave Background  -->
<div class="ocean">
    <div class="wave"></div>
    <div class="wave"></div>
</div>
<!-- Log In Form Section -->
<section>
    <div class="container" id="container">
        <div class="form-container sign-in-container">
            <form action="" method="post" class="login">
                <?php
                    include("modelo\conexion_bd.php");
                    include("controlador\controlador_inicio_sesion.php");        
                ?> 
                <h1 style="margin-bottom: 20px;color:indigo; font-size:35px; ">
                Iniciar Sesión</h1>
                <label>
                    <input type="text" name="rut_cliente" id="rut_cliente_login" placeholder="RUT" required style="background: #eee; border: none; border-radius: 50px; padding: 12px 15px;width:100%"/>
                </label>
                <label>
                    <input type="password" name="clave" placeholder="Contraseña" required style="background: #eee; border: none; border-radius: 50px; padding: 12px 15px;width:100%; margin-top:5px"/>
                </label>
                <div class="cuadroiniciar" >
                    <input class="boton" type="submit" value="Ingresar" name="btniniciar" style="color: white;background-color:slateblue; font-size:15px; border: none; border-radius: 50px; padding: 12px 15px;margin-top:20px">
                </div>
            </form>
        </div>

        <div class="form-container sign-up-container">
            <form action="procesarClientePagCliente.php" method="post" autocomplete="off" style="padding-right: 10px;">
                <h1 style="margin-bottom: 20px;color:navy; font-size:30px;">Registro</h1>
                
                <div style="display: grid;grid-template-columns: repeat(2, 1fr);gap: 5px;">                      
                    <label>
                        <input type="text" name="rut_cliente" id="rut_cliente_registro" placeholder="RUT" required style="background: #eee; border: none; border-radius: 50px; padding: 12px 15px;width:90%"/>
                    </label>
                    <label>
                        <input type="password" placeholder="Clave" name="clave" required style="background: #eee; border: none; border-radius: 50px; padding: 12px 15px;width:90%"/>
                    </label>
                    <label>
                        <input type="text" name="nombre_cliente" id="nombre_cliente" placeholder="Nombre" required style="background: #eee; border: none; border-radius: 50px; padding: 12px 15px;width:90%"/>
                    </label>
                    <label>
                        <input type="text" name="apellido_cliente" id="apellido_cliente" placeholder="Apellido" required style="background: #eee; border: none; border-radius: 50px; padding: 12px 15px;width:90%"/>
                    </label>
                    <label>
                        <input type="email" name="email" placeholder="Email" required style="background: #eee; border: none; border-radius: 50px; padding: 12px 15px;width:90%"/>
                    </label>
                    <label>
                        <input type="number" name="telefono" placeholder="Teléfono" required style="background: #eee; border: none; border-radius: 50px; padding: 12px 15px;width:90%"/>
                    </label>
                    <label>
                        <input type="text" name="direccion" id="direccion" placeholder="Dirección" required style="background: #eee; border: none; border-radius: 50px; padding: 12px 15px;width:90%"/>
                    </label>

                    <label>
                        <select class="selects" data-choices name="id_comuna" id="choices-single-default" required
                        style="background: #eee; border: none; border-radius: 50px; padding: 12px 15px; ">
                            <option value="">Seleccione comuna</option>
                            <?php
                            // Establecer conexión a la base de datos
                            include("modelo\conexion_bd.php");

                            // Consulta SQL para obtener las opciones
                            $sql = "SELECT id_comuna, nombre_comuna FROM comuna";
                            $result = $conexion->query($sql);

                            // Confirma si hay resultados, ordenandolos por id 
                            // Si no hay datos, muestra la opción de no hay registros
                            if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row["id_comuna"] . "'>" . $row["nombre_comuna"] . "</option>";
                                }
                            }else{
                                echo "<option value=''>No hay registros de comunas</option>";
                            }

                            $conexion->close();
                            ?>
                        </select>
                    </label>

                    <label>
                        <select class="selects" name="parentesco" required
                        style="background: #eee; border: none; border-radius: 50px; padding: 12px 15px; ">
                            <option value="">Ingrese parentesco</option>
                            <option value="Padre" required>Padre</option>
                            <option value="Madre" required>Madre</option>
                            <option value="Abuelo" required>Abuelo</option>
                            <option value="Abuela" required>Abuela</option>
                            <option value="Tía" required>Tía</option>
                            <option value="Tío" required>Tío</option>
                        </select>
                    </label>

                    <label>
                        <input type="text" id="date-field" class="form-control" placeholder="Cliente" required name="rol" value="Cliente" readonly style="display: none"/>
                    </label>
                                 
                </div>
                <button type="submit" value="Enviar" style="margin-top: 9px">Registrarse</button>
            </form>
        </div>

        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1 style="font-size: 35px;">Inicia Sesión</h1>
                    <p style="font-size: 15px;">Inicie sesión aquí si ya tiene una cuenta</p>
                    <button class="ghost mt-5" id="signIn">Iniciar sesión</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1 style="font-size: 35px;">¡Regístrate!</h1>
                    <p style="font-size:15px">Regístrate aquí si aún no tienes una cuenta </p>
                    <button class="ghost" id="signUp">Registrarse</button>    
                </div>
            </div>
        </div>
    </div>
</section>

<script> 
    const signUpButton = document.getElementById('signUp');
    const signInButton = document.getElementById('signIn');
    const container = document.getElementById('container');

    signUpButton.addEventListener('click', () =>
        container.classList.add('right-panel-active'));

    signInButton.addEventListener('click', () =>
        container.classList.remove('right-panel-active'));

    function formatRUT(rut) {
        // Elimina los puntos y el guion existentes
        rut = rut.replace(/[.-]/g, '');
        
        // Divide el RUT en el número y el dígito verificador
        let cuerpo = rut.slice(0, -1);
        let dv = rut.slice(-1).toUpperCase();
        
        // Añade los puntos cada tres dígitos
        cuerpo = cuerpo.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        
        // Junta el número con el dígito verificador
        return `${cuerpo}-${dv}`;
    }

    function validateRUT(input) {
        let rut = input.value;
        if (rut.length > 1) {
            input.value = formatRUT(rut);
        }
    }

    document.getElementById('rut_cliente_login').addEventListener('input', function() {
        validateRUT(this);
    });

    document.getElementById('rut_cliente_registro').addEventListener('input', function() {
        validateRUT(this);
    });

    function capitalizeFirstLetter(input) {
        input.value = input.value.charAt(0).toUpperCase() + input.value.slice(1);
    }

    document.getElementById('nombre_cliente').addEventListener('input', function() {
        capitalizeFirstLetter(this);
    });

    document.getElementById('apellido_cliente').addEventListener('input', function() {
        capitalizeFirstLetter(this);
    });

    document.getElementById('direccion').addEventListener('input', function() {
        capitalizeFirstLetter(this);
    });

</script>
</body>
</html>
