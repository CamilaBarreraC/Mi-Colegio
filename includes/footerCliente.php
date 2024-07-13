<style>
    @import url(https://fonts.googleapis.com/css2?family=Barlow:wght@100&display=swap);
    @import url(https://fonts.googleapis.com/css2?family=Barlow:wght@700&display=swap);
    @import url(https://fonts.googleapis.com/css2?family=Barlow:ital,wght@1,500&display=swap);
    @import url(https://fonts.googleapis.com/css2?family=Aleo&display=swap);
    @import url(https://fonts.googleapis.com/css2?family=Barlow:ital,wght@1,600&display=swap);
    @import url(https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap);

    .cont {
        width: 100%;
        height: 100%;
        flex-grow: 0;
        padding: 24.3px 189px 36px 105px;
        background-color: #5c46ea;
    }

    img.imagen_footer {
        width: 170.3px;
        height: 156.1px;
        flex-grow: 0;
        margin: 0 40.7px 20.1px 70px;
        object-fit: contain;
    }

    .logo_footer {
        width: 100%;
        height: 100%;
        flex-grow: 0;
        font-family: "Be Vietnam Pro", sans-serif;
        font-size: 60px;
        font-weight: bold;
        font-stretch: normal;
        font-style: italic;
        line-height: normal;
        letter-spacing: normal;
        text-align: center;
        color: #fff;
    }

    .logo_footer:hover{
        color:plum;
    }

    .contacto {
        width: 267.2px;
        height: 79.2px;
        flex-grow: 0;
        margin: 0 39.1px 16.7px 17.7px;
        font-family: "Be Vietnam Pro", sans-serif;
        font-size: 50px;
        font-weight: bold;
        font-stretch: normal;
        font-style: italic;
        line-height: normal;
        letter-spacing: normal;
        text-align: center;
        color: #fff;
    }

    .contacto:hover{
        color:aqua;
    }

    .custom-list{
        list-style-type: none; /* Quita el estilo por defecto */
        padding-left: 20px; 
        margin: 30px 0px; 
        flex-grow: 0;
        font-family: "Be Vietnam Pro", sans-serif;
        font-size: 30px;
        font-weight: 200;
        color: #fff;
    }

    li{
        margin-bottom: 10px;
    }
    
    .bxl-facebook-circle:hover{
        color: blue;
    }

    .bxl-instagram-alt:hover{
        color: deeppink;
    }

    .bxl-gmail:hover{
        color: red;
    }

    

</style>

<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="cont" style="display:inline-flex;">
                <div>
                    <a href="PagCliente.php">
                        <img src="micolegioImg/logo_sidebar.png" class="imagen_footer"><br>
                        <span class="logo_footer">Mi Colegio </span>
                    </a>            
                </div>
                <div style="margin-left: 440.7px;">
                    <span class="contacto">Contacto</span>
                    <ul class="custom-list" style="color: white;">
                        <li><a href="https://www.facebook.com/dimeiggs" style="color: white;"><i class="bx bxl-facebook-circle"></i>  MiColegio_fb</a></li>
                        <li><a href="https://www.instagram.com/dimeiggscl/" style="color: white;" ><i class="bx bx bxl-instagram-alt"></i>  @MiColegio</a></li>
                        <li><a style="color: white;" ><i class="bx bxl-gmail"></i>  Mi@colegio.cl</a></li>
                    </ul>
                </div>    
            </div>
        </div>
    </div>
</footer>