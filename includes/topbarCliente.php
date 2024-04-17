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
        <img src="micolegioImg/logo.png" style="width: 40px; position:relative;">
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

<!-- removeNotificationModal -->
<div id="removeNotificationModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="NotificationModalbtn-close"></button>
            </div>
            <div class="modal-body">
                <div class="mt-2 text-center">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                        <h4>Are you sure ?</h4>
                        <p class="text-muted mx-4 mb-0">Are you sure you want to remove this Notification ?</p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn w-sm btn-danger" id="delete-notification">Yes, Delete It!</button>
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


