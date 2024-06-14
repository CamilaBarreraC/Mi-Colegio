<!-- SIDEBAR 2 PARA PÁGINA CLIENTE, SIRVE PARA QUE FUNCIONE EL SELECT DE LOS COLEGIOS CON BÚSQUEDA -->

<style>
    .app-menu{
        background-color: rgb(196, 209, 255) !important;
    }

    /* STYLE PARA CAMBIAR COLOR AL SIDEBAR */
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

    .app-menu {
        display: none;
    }
</style>

<div class="app-menu navbar-menu" style="background-color: rgb(1, 79, 197); ">
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
            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background" style="background-color: 282828;"></div>
</div>

