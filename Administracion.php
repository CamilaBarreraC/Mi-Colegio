<!DOCTYPE html>
<html lang="es">

<?php include 'layouts/session.php'; ?>
<?php include 'layouts/main.php'; ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Colegio</title>
    <link rel="icon" type="icon" href="micolegioImg/logo.png"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php includeFileWithVariables('layouts/title-meta.php', array('title' => 'Dashboard')); ?>

    <!-- jsvectormap css -->
    <link href="assets/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css" />

    <!--Swiper slider css-->
    <link href="assets/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css" />

    <?php include 'layouts/head-css.php'; ?>

</head>

<style>
    @import url(https://fonts.googleapis.com/css2?family=Barlow:wght@100&display=swap);
    @import url(https://fonts.googleapis.com/css2?family=Barlow:wght@700&display=swap);
    @import url(https://fonts.googleapis.com/css2?family=Barlow:ital,wght@1,500&display=swap);
    @import url(https://fonts.googleapis.com/css2?family=Aleo&display=swap);
    @import url(https://fonts.googleapis.com/css2?family=Barlow:ital,wght@1,600&display=swap);

    .inicio{
        width: 1440px; 
        height: 1024px; 
    }
</style>

<body>
    <!-- Agrega el sidebar y topbar -->
    <?php include 'includes/sidebar.php'; ?>
    <?php include 'includes/topbar.php'; ?>

    <!-- Begin page -->
        <div id="layout-wrapper">
            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">

                        <div class="row">
                            <div class="col">
                                <div class="h-100">
                                    <div class="row mb-3 pb-1">
                                        <div class="col-12">
                                            <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                                                <div class="flex-grow-1">
                                                    <h4 class="fs-16 mb-1">¡Bienvenido, Administrador!</h4>
                                                    <p class="text-muted mb-0">Estos son los reportes de "Mi Colegio".</p>
                                                </div>                        
                                            </div><!-- end card header -->
                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end row-->

                                    <div class="row">
                                        <div class="col-xl-3 col-md-6">
                                            <!-- card -->
                                            <div class="card card-animate">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-grow-1 overflow-hidden">
                                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> Total Earnings</p>
                                                        </div>
                                                        <div class="flex-shrink-0">
                                                            <h5 class="text-success fs-14 mb-0">
                                                                <i class="ri-arrow-right-up-line fs-13 align-middle"></i> +16.24 %
                                                            </h5>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                                        <div>
                                                            <h4 class="fs-22 fw-semibold ff-secondary mb-4">$<span class="counter-value" data-target="559.25">0</span>k </h4>
                                                            <a href="" class="text-decoration-underline">View net earnings</a>
                                                        </div>
                                                        <div class="avatar-sm flex-shrink-0">
                                                            <span class="avatar-title bg-primary-subtle rounded fs-3">
                                                                <i class="bx bx-dollar-circle text-primary"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div><!-- end card body -->
                                            </div><!-- end card -->
                                        </div><!-- end col -->

                                        <div class="col-xl-3 col-md-6">
                                            <!-- card -->
                                            <div class="card card-animate">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-grow-1 overflow-hidden">
                                                         <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Orders</p>
                                                        </div>
                                                        <div class="flex-shrink-0">
                                                            <h5 class="text-danger fs-14 mb-0">
                                                                <i class="ri-arrow-right-down-line fs-13 align-middle"></i> -3.57 %
                                                            </h5>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                                        <div>
                                                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="36894">0</span></h4>
                                                            <a href="" class="text-decoration-underline">View all orders</a>
                                                        </div>
                                                        <div class="avatar-sm flex-shrink-0">
                                                            <span class="avatar-title bg-info-subtle rounded fs-3">
                                                                <i class="bx bx-shopping-bag text-info"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div><!-- end card body -->
                                            </div><!-- end card -->
                                        </div><!-- end col -->

                                        <div class="col-xl-3 col-md-6">
                                            <!-- card -->
                                            <div class="card card-animate">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-grow-1 overflow-hidden">
                                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Customers</p>
                                                        </div>
                                                        <div class="flex-shrink-0">
                                                            <h5 class="text-success fs-14 mb-0">
                                                                <i class="ri-arrow-right-up-line fs-13 align-middle"></i> +29.08 %
                                                            </h5>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                                        <div>
                                                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="183.35">0</span>M </h4>
                                                            <a href="" class="text-decoration-underline">See details</a>
                                                        </div>
                                                        <div class="avatar-sm flex-shrink-0">
                                                            <span class="avatar-title bg-primary-subtle rounded fs-3">
                                                                <i class="bx bx-user-circle text-primary"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div><!-- end card body -->
                                            </div><!-- end card -->
                                        </div><!-- end col -->

                                        <div class="col-xl-3 col-md-6">
                                            <!-- card -->
                                            <div class="card card-animate">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-grow-1 overflow-hidden">
                                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> My Balance</p>
                                                        </div>
                                                        <div class="flex-shrink-0">
                                                            <h5 class="text-muted fs-14 mb-0">
                                                                +0.00 %
                                                            </h5>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                                        <div>
                                                            <h4 class="fs-22 fw-semibold ff-secondary mb-4">$<span class="counter-value" data-target="165.89">0</span>k </h4>
                                                            <a href="" class="text-decoration-underline">Withdraw money</a>
                                                        </div>
                                                        <div class="avatar-sm flex-shrink-0">
                                                            <span class="avatar-title bg-info-subtle rounded fs-3">
                                                                <i class="bx bx-wallet text-info"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div><!-- end card body -->
                                            </div><!-- end card -->
                                        </div><!-- end col -->
                                    </div> <!-- end row-->                          

                                    <div class="row">                                       
                                        <div class="col-xl-8">
                                            <div class="card">
                                                <div class="card-header align-items-center d-flex">
                                                    <h4 class="card-title mb-0 flex-grow-1">Recent Orders</h4>
                                                    <div class="flex-shrink-0">
                                                        <button type="button" class="btn btn-soft-info btn-sm">
                                                            <i class="ri-file-list-3-line align-middle"></i> Generate Report
                                                        </button>
                                                    </div>
                                                </div><!-- end card header -->

                                                <div class="card-body">
                                                    <div class="table-responsive table-card">
                                                        <table class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                                            <thead class="text-muted table-light">
                                                                <tr>
                                                                    <th scope="col">Order ID</th>
                                                                    <th scope="col">Customer</th>
                                                                    <th scope="col">Product</th>
                                                                    <th scope="col">Amount</th>
                                                                    <th scope="col">Vendor</th>
                                                                    <th scope="col">Status</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        <a href="apps-ecommerce-order-details.php" class="fw-medium link-primary">#VZ2112</a>
                                                                    </td>
                                                                    <td>
                                                                        <div class="d-flex align-items-center">
                                                                            <div class="flex-shrink-0 me-2">
                                                                                <img src="assets/images/users/avatar-1.jpg" alt="" class="avatar-xs rounded-circle" />
                                                                            </div>
                                                                            <div class="flex-grow-1">Alex Smith</div>
                                                                        </div>
                                                                    </td>
                                                                    <td>Clothes</td>
                                                                    <td>
                                                                        <span class="text-success">$109.00</span>
                                                                    </td>
                                                                    <td>Zoetic Fashion</td>
                                                                    <td>
                                                                        <span class="badge bg-success-subtle text-success">Paid</span>
                                                                    </td>
                                                                </tr><!-- end tr -->
                                                                <tr>
                                                                    <td>
                                                                        <a href="apps-ecommerce-order-details.php" class="fw-medium link-primary">#VZ2111</a>
                                                                    </td>
                                                                    <td>
                                                                        <div class="d-flex align-items-center">
                                                                            <div class="flex-shrink-0 me-2">
                                                                                <img src="assets/images/users/avatar-2.jpg" alt="" class="avatar-xs rounded-circle" />
                                                                            </div>
                                                                            <div class="flex-grow-1">Jansh Brown</div>
                                                                        </div>
                                                                    </td>
                                                                    <td>Kitchen Storage</td>
                                                                    <td>
                                                                        <span class="text-success">$149.00</span>
                                                                    </td>
                                                                    <td>Micro Design</td>
                                                                    <td>
                                                                        <span class="badge bg-warning-subtle text-warning">Pending</span>
                                                                    </td>
                                                                </tr><!-- end tr -->
                                                                <tr>
                                                                    <td>
                                                                        <a href="apps-ecommerce-order-details.php" class="fw-medium link-primary">#VZ2109</a>
                                                                    </td>
                                                                    <td>
                                                                        <div class="d-flex align-items-center">
                                                                            <div class="flex-shrink-0 me-2">
                                                                                <img src="assets/images/users/avatar-3.jpg" alt="" class="avatar-xs rounded-circle" />
                                                                            </div>
                                                                            <div class="flex-grow-1">Ayaan Bowen</div>
                                                                        </div>
                                                                    </td>
                                                                    <td>Bike Accessories</td>
                                                                    <td>
                                                                        <span class="text-success">$215.00</span>
                                                                    </td>
                                                                    <td>Nesta Technologies</td>
                                                                    <td>
                                                                        <span class="badge bg-success-subtle text-success">Paid</span>
                                                                    </td>
                                                                </tr><!-- end tr -->
                                                                <tr>
                                                                    <td>
                                                                        <a href="apps-ecommerce-order-details.php" class="fw-medium link-primary">#VZ2108</a>
                                                                    </td>
                                                                    <td>
                                                                        <div class="d-flex align-items-center">
                                                                            <div class="flex-shrink-0 me-2">
                                                                                <img src="assets/images/users/avatar-4.jpg" alt="" class="avatar-xs rounded-circle" />
                                                                            </div>
                                                                            <div class="flex-grow-1">Prezy Mark</div>
                                                                        </div>
                                                                    </td>
                                                                    <td>Furniture</td>
                                                                    <td>
                                                                        <span class="text-success">$199.00</span>
                                                                    </td>
                                                                    <td>Syntyce Solutions</td>
                                                                    <td>
                                                                        <span class="badge bg-danger-subtle text-danger">Unpaid</span>
                                                                    </td>
                                                                </tr><!-- end tr -->
                                                                <tr>
                                                                    <td>
                                                                        <a href="apps-ecommerce-order-details.php" class="fw-medium link-primary">#VZ2107</a>
                                                                    </td>
                                                                    <td>
                                                                        <div class="d-flex align-items-center">
                                                                            <div class="flex-shrink-0 me-2">
                                                                                <img src="assets/images/users/avatar-6.jpg" alt="" class="avatar-xs rounded-circle" />
                                                                            </div>
                                                                            <div class="flex-grow-1">Vihan Hudda</div>
                                                                        </div>
                                                                    </td>
                                                                    <td>Bags and Wallets</td>
                                                                    <td>
                                                                        <span class="text-success">$330.00</span>
                                                                    </td>
                                                                    <td>iTest Factory</td>
                                                                    <td>
                                                                        <span class="badge bg-success-subtle text-success">Paid</span>
                                                                    </td>
                                                                </tr><!-- end tr -->
                                                            </tbody><!-- end tbody -->
                                                        </table><!-- end table -->
                                                    </div>
                                                </div>
                                            </div> <!-- .card-->
                                        </div> <!-- .col-->
                                    </div> <!-- end row-->

                                </div> <!-- end .h-100-->

                            </div> <!-- end col -->
                        </div>

                    </div>
                    <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        <?php include 'layouts/vendor-scripts.php'; ?>

        <!-- apexcharts -->
        <script src="assets/libs/apexcharts/apexcharts.min.js"></script>

        <!-- Vector map-->
        <script src="assets/libs/jsvectormap/js/jsvectormap.min.js"></script>
        <script src="assets/libs/jsvectormap/maps/world-merc.js"></script>

        <!--Swiper slider js-->
        <script src="assets/libs/swiper/swiper-bundle.min.js"></script>

        <!-- Dashboard init -->
        <script src="assets/js/pages/dashboard-ecommerce.init.js"></script>

        <!-- App js -->
        <script src="assets/js/app.js"></script>

</body>
</html>