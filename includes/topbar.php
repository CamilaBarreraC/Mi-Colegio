<style>
    @import url(https://fonts.googleapis.com/css2?family=Barlow:wght@100&display=swap);
    @import url(https://fonts.googleapis.com/css2?family=Barlow:wght@700&display=swap);
    @import url(https://fonts.googleapis.com/css2?family=Barlow:ital,wght@1,500&display=swap);
    @import url(https://fonts.googleapis.com/css2?family=Aleo&display=swap);
    @import url(https://fonts.googleapis.com/css2?family=Barlow:ital,wght@1,600&display=swap);
</style>

<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header" style="background-color: white">
            <div class="d-flex align-items-center">
                <h1 style="align-items: center;text-align:center; color:#3F98FF;font-family: Barlow; font-style: italic;font-weight: 1000; font-size: 40px; ">Mi Colegio</h1>
            </div>

            <div class="d-flex align-items-center">
                <div class="dropdown ms-sm-3 header-item topbar-user" style="background-color: rgb(241, 251, 255);">
                    <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                        <span class="d-flex align-items-center" >
                            <!-- Datos del usuario que inicia sesión, imagen de perfil y nombre del usuario -->
                            <img class="rounded-circle header-profile-user" src="micolegioImg/logo.png" alt="Header Avatar">
                            <span class="text-start ms-xl-2" >                              
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text" style="color:rgb(40, 5, 116)"> <?php echo $_SESSION['nombre_cliente']; ?> </span>
                                <span class="d-none d-xl-block ms-1 fs-12 user-name-sub-text"><?php  ?></span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href=#><i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-key="t-logout" onclick="confirmCerrar()">Cerrar sesión</span></a>
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
                                    window.location.href = "Administracion.php";
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
