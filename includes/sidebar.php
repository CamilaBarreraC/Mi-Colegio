<!-- SIDEBAR-->

<style>
    span:hover{
        color: blue;
    }
</style>

<div class="app-menu navbar-menu" style="background-color: rgba(219, 228, 255, 0.8); ">
    <!-- LOGO -->
    <div class="navbar-brand-box" >      
        <!-- Light Logo-->
        <a href="index.php" class="logo logo-light">
            <span class="logo-sm">
                <img src="assets/images/logo-sm.png" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="assets/images/logo-light.png" alt="" height="17">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover" style="background-color: rgba(225, 233, 255, 0.44) ;">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid" style="background-color: white ;">

            <div id="two-column-menu" style="background-color: rgba(230, 237, 252, 1) ;">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu" style="color: rgba(0, 12, 82, 1);">Menú</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarDashboards" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class="bx bx-user-circle"></i> <span data-key="t-dashboards">Usuarios</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarDashboards">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="Usuarios.php" class="nav-link"> Gestionar usuarios </a>
                            </li>
                        </ul>
                    </div>
                </li> <!-- end Dashboard Menu -->

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarCRM" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class=" bx bx-user-plus"></i> <span data-key="t-dashboards">Alumnos</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarCRM">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="Alumnos.php" class="nav-link"> Gestionar alumnos </a>
                            </li>
                        </ul>
                    </div>
                </li> <!-- end Dashboard Menu -->

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarApps" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarApps">
                        <i class="bx bxs-school"></i> <span data-key="t-apps">Colegios</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarApps">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="Colegios.php" class="nav-link"> Gestionar colegios </a>
                            </li>    
                            <li class="nav-item">
                                <a href="Cursos.php" class="nav-link"> Gestionar cursos </a>
                            </li>                                                                                       
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarTasks" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class=" bx bx-list-ol"></i> <span data-key="t-dashboards">Listas</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarTasks">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="Listas1.php" class="nav-link"> Gestionar listas </a>
                            </li>
                        </ul>
                    </div>
                </li> <!-- end Dashboard Menu -->

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarProjects" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class=" bx bx-pencil"></i> <span data-key="t-dashboards">Productos</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarProjects">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="Productos.php" class="nav-link"> Gestionar productos y categorías</a>
                            </li>
                        </ul>
                    </div>
                </li> <!-- end Dashboard Menu -->

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarEcommerce" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class=" ri-clipboard-line"></i> <span data-key="t-dashboards">Pedidos</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarEcommerce">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="Pedidos.php" class="nav-link"> Gestionar pedidos </a>
                            </li>
                        </ul>
                    </div>
                </li> <!-- end Dashboard Menu -->

            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>