<!-- ========== App Menu ========== -->

<style>
    .app-menu{
        background-color: rgb(196, 209, 255) !important;
    }

    :root[data-sidebar=light] {
        --vz-vertical-menu-bg: #405189;
        --vz-vertical-menu-border: #405189;
        --vz-vertical-menu-item-color: rgb(196, 209, 255);
        --vz-vertical-menu-item-bg: rgb(196, 209, 255);
        --vz-vertical-menu-item-hover-color: #ff0000;
        --vz-vertical-menu-item-active-color: #fff;
        --vz-vertical-menu-item-active-bg: rgb(196, 209, 255);
        --vz-vertical-menu-sub-item-color: #ffffff;
        --vz-vertical-menu-sub-item-hover-color: #ff0000;
        --vz-vertical-menu-sub-item-active-color: #fff;
        --vz-vertical-menu-title-color: rgb(196, 209, 255);
        --vz-twocolumn-menu-iconview-bg: #ffffff;
        --vz-vertical-menu-box-shadow: 0 2px 4px rgba(255, 255, 255, 0.879);
        --vz-vertical-menu-dropdown-box-shadow: 0 2px 4px rgba(15, 34, 58, 0.12);
    }

    a:hover{
        color: blue;
    }
</style>

<div class="app-menu navbar-menu" style="background-color: rgb(1, 79, 197);">
    <!-- LOGO -->
    <div class="navbar-brand-box" style="background-color: rgb(1, 79, 197);">
        <!-- Light Logo-->
        <a href="Administracion.php" class="logo logo-light">
            <span class="logo-lg">
                <img src="micolegioImg/logo_sidebar.png" alt="" height="100" width="110" style="margin-bottom: 30px;margin-top:20px">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar" style="background-color: rgb(1, 79, 197);">
        <div class="container-fluid" style="background-color:rgb(1, 79, 197);">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title" style="color: white"><span data-key="t-menu">Menú</span></li>

                <!-- Lista de usuarios en sidebar -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarDashboards" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class=" ri-user-fill" style="color: white"></i> <span style="color: white; font-family: Barlow; font-style: italic; font-size:20px">Usuarios</span>
                    </a>
                    <!-- Sublistas de usuario -->
                    <div class="collapse menu-dropdown" id="sidebarDashboards">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="registro_usuario.php" class="nav-link" style="color: white"></i> <span style="color: white; font-family: Barlow; font-style: italic; font-size:15px"> Agregar usuario </a>
                            </li>
                            <li class="nav-item">
                                <a href="verUsuarios.php" class="nav-link" style="color: white"></i> <span style="color: white; font-family: Barlow; font-style: italic; font-size:15px"> Ver empleados </a>
                            </li>
                        </ul>
                    </div>
                </li><!-- end Dashboard Menu -->

                <!-- Lista de cliente en sidebar -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarTasks" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarTasks">
                        <i class=" ri-user-fill" style="color: white;"></i> <span style="color: white; font-family: Barlow; font-style: italic; font-size:20px">Colegios</span>
                    </a>
                    <!-- Sublistas de cliente -->
                    <div class="collapse menu-dropdown" id="sidebarTasks">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="Colegios.php" class="nav-link" style="color: white"></i> <span style="color: white; font-family: Barlow; font-style: italic; font-size:15px"> Buscar colegios </a>
                            </li>
                        </ul>
                    </div>
                </li><!-- end Dashboard Menu -->

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarEcommerce" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarTasks">
                        <i class="ri-file-edit-fill" style="color:white" ></i> <span style="color: white; font-family: Barlow; font-style: italic; font-size:20px">Clases</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarEcommerce">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="ingresoclases.php" class="nav-link"> Ingreso de clases </a>
                            </li>            
                        </ul>
                    </div>
                </li><!-- end Dashboard Menu -->

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarApps" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarApps">
                        <i class="bx bxs-calendar-event" style="color:white"></i> <span style="color: white; font-family: Barlow; font-style: italic; font-size:20px">Reportes</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarApps">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="Reporte.php" class="nav-link" style="color: white"></i> <span style="color: white; font-family: Barlow; font-style: italic; font-size:15px"> Reporte </a>
                            </li>
                        </ul>
                    </div>
                </li><!-- end Dashboard Menu -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarLayouts" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarLayouts">
                        <i class="mdi-dumbbell" style="color:white"></i> <span style="color: white; font-family: Barlow; font-style: italic; font-size:20px">Inventario</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarLayouts">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="equipos.php" class="nav-link">Equipos de gimnasio</a>
                            </li>
                            <li class="nav-item">
                                <a href="salas.php" class="nav-link">Salas de entrenamiento</a>
                            </li>
                        </ul>
                    </div>
                </li><!-- end Dashboard Menu -->

            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background" style="background-color: 282828;"></div>
</div>

