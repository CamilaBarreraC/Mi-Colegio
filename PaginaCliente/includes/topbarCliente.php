<style>
    .dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
    }

    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    .dropdown-content a:hover {
        background-color: #f1f1f1;
    }

    .show {
        display: block;
    }
</style>

<header>
    <span class="dropdown">
        <img src="../micolegio img/logo.png" style="width: 40px; position:relative;">
        <span class="dropdown-toggle" onclick="toggleDropdown()" style="color:rgb(40, 5, 116)"><?php echo $_SESSION['nombre_cliente']; ?></span>
        <div class="dropdown-content" id="ContenidoDropdown">
            <!-- onclick, al seleccionar el apartado, se despliega la opción de cerrar sesión,
            con la función "confirmCerrar", ubicada abajo -->
            <a onclick="confirmCerrar()">Cerrar sesión</a>

            <!-- JavaScript para mostrar la confirmación -->
            <script>
                function confirmCerrar() {
                // Mostrar la confirmación con SweetAlert
                    Swal.fire({
                        title: "Cerrar sesión",
                        text: "¿Desea cerrar sesión?",
                        icon: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Sí, cerrar sesión",
                        cancelButtonText: "Cancelar"
                    }).then((result) => {
                        window.location.href = "PagCliente.php";
                        if (result.isConfirmed) {
                            // Redireccionar a la página de iniciar sesión
                            window.location.href = "../index.php";
                            session_unset();
                            session_destroy();                                   
                        }
                    });
                }
            </script>
        </div>
    </span>

    <script>
        function toggleDropdown() {
            document.getElementById("ContenidoDropdown").classList.toggle("show");
        }

        // Cerrar el dropdown si se hace clic fuera de él
        window.onclick = function(evento) {
            if (!evento.target.matches('.dropdown-toggle')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                var i;
                for (i = 0; i < dropdowns.length; i++) {
                    var abrirDropdown = dropdowns[i];
                    if (abrirDropdown.classList.contains('show')) {
                        abrirDropdown.classList.remove('show');
                    }
                }
            }
        }
    </script>
</header>

