<style>
    @import url(https://fonts.googleapis.com/css2?family=Barlow:wght@100&display=swap);
    @import url(https://fonts.googleapis.com/css2?family=Barlow:wght@700&display=swap);
    @import url(https://fonts.googleapis.com/css2?family=Barlow:ital,wght@1,500&display=swap);
    @import url(https://fonts.googleapis.com/css2?family=Aleo&display=swap);
    @import url(https://fonts.googleapis.com/css2?family=Barlow:ital,wght@1,600&display=swap);
</style>

<header id="page-topbar" style="background-color: rgba(105, 94, 239, 1);">
    <div class="layout-width" style="background-color: rgba(105, 94, 239, 1)">
        <div class="navbar-header" style="background-color: rgba(105, 94, 239, 1);">
            <div class="d-flex" style="background-color: rgba(105, 94, 239, 1);">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="Administracion.php" class="logo logo-light">        
                        <span class="logo-lg">
                            <img src="micolegioImg/logo_sidebar.png" alt="" height="65">           
                        </span>
                    </a>
                </div>
                <h1 style="align-items: center;text-align:center; color:rgba(230, 237, 252, 1);font-family: Barlow; font-style: italic;font-weight: 1000; font-size: 40px; margin-top: 10px">Mi Colegio</h1>

                <!-- NO BORRAR -->
                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>      
            </div>
                

            <div class="d-flex align-items-center">
                <div class="dropdown ms-sm-3 header-item topbar-user" style="background-color: #223558; width:140px;">
                    <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                        <span class="d-flex align-items-center" >
                            <!-- Datos del usuario que inicia sesión, imagen de perfil y nombre del usuario -->
                            <img class="rounded-circle header-profile-user" src="micolegioImg/logo_sidebar.png" alt="Header Avatar">
                            <span class="text-start ms-xl-2" >                              
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text" style="color:white"> <?php echo $_SESSION['nombre_cliente']; ?> </span>
                                <span class="d-none d-xl-block ms-1 fs-12 user-name-sub-text"><?php  ?></span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" >
                        <h6 class="dropdown-header">¡Bienvenid@ <?php echo $_SESSION['nombre_cliente']; ?>!</h6>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item"><i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-key="t-logout" onclick="confirmCerrar()">Cerrar sesión</span></a>
                        <!-- botón cerrar sesión -->

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

                                    if (result.isConfirmed) {
                                        // Redireccionar a la página de iniciar sesión
                                        window.location.href = "index.php";
                                        session_unset();
                                        session_destroy();                    
                                    }
                                });
                            }
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
