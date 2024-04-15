<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Colegio</title>
    <link rel="stylesheet" href="css/estilo.css">  
    <link rel="icon" type="icon" href="micolegioImg/logo icono.png"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <!-- Panel para dimensiones de escritorio -->
    <div class="Panel_escritorio" style="height: 900px; background-color:rgb(239, 248, 255)">

        <div class="cuadro_decoracion"></div>
        <img class="logo" src="micolegiImg/logotop.png" style="width: 150px;height: 68px; left: 1280px" />    
        
        <img class="decoracion" src="micolegioImg/deco.png" style="top: 570px"/>

        <div class="container">
            <img class="cuadrologin" src="micolegioImg/cuadrologin.png" style="left: 88px;"/>

            <form action="" method="post" class="login">          
                <?php
                    include("modelo\conexion_bd.php");
                    include("controlador\controlador_inicio_sesion.php");        
                ?>     
                <input type="text" name="rut_cliente" placeholder="Usuario" >               
                <input type="password" name="clave" placeholder="Contraseña">   
               
                <div class="cuadroiniciar">
                    <input class="boton" type="submit" value="Ingresar" name="btniniciar">
                </div>
            </form>

        </div>    

        <img class="logo_user" src="micolegioImg/icono user.png" />
        <img class="logo_pass" src="micolegioImg/icono pass.png" />
        <div style="width: 211px; height: 0px; left: 614px; top: 530px; position: absolute; border: 1px #001AFF solid"></div>
        
    </div>   
</body>
</html>