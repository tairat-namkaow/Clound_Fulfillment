<?php
require_once('connections/mysqli.php');

$sql_admin = "SELECT * FROM `admin` WHERE Admin_user = '" . $_SESSION['Admin_user'] . "'";
$query_admin = mysqli_query($Connection, $sql_admin);
$result_admin = mysqli_fetch_array($query_admin);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Cloud_Fulfillment</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="admin_dashboard.php">Admin Dashboard</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
            </div>
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">

                    <li><a class="dropdown-item" href="#!"><?php echo $result_admin[3]; ?></a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="admin_information.php">แก้ไขข้อมูล</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><button class="dropdown-item" type="button" onclick="window.location.href='logout.php'">ออกจากระบบ</button></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">MENU</div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Admin Operation
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="admin_dashboard.php">Dashboard</a>
                                <a class="nav-link" href="admin_category.php">Category</a>
                                <a class="nav-link" href="admin_In_bound.php">In-bound</a>
                                <a class="nav-link" href="admin_inventory.php">Inventory</a>
                                <a class="nav-link" href="admin_order.php">Order</a>
                                <a class="nav-link" href="admin_export_data.php">Download</a>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    <?php echo $result_admin[3]; ?>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Admin Dashboard</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Admin Dashboard</li>
                    </ol>
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body">Primary Card</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="#">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-warning text-white mb-4">
                                <div class="card-body">Warning Card</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="#">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-success text-white mb-4">
                                <div class="card-body">Success Card</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="#">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-danger text-white mb-4">
                                <div class="card-body">Danger Card</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="#">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                    $sql_test = "SELECT * FROM Product_detail
                    INNER JOIN shop ON product_detail.shop_id = shop.Shop_id
                    INNER JOIN product ON product_detail.Product_id = product.Product_id
                    INNER join product_category on Product.Category_id = product_category.Category_id
                    GROUP by Category_name";

                    $query_test = mysqli_query($Connection, $sql_test);
                    $datax = array();
                    while ($k = mysqli_fetch_assoc($query_test)) {
                        $datax[] = "['" . $k['Category_name'] . "'" . ", " . $k['Product_quantity'] . "]";
                    }
                    $datax = implode(",", $datax);
                    ?>

                    <html>

                    <head>
                        <!-- เรียก js มาใช้งาน -->
                        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                        <script type="text/javascript">
                            google.charts.load('current', {
                                'packages': ['corechart']
                            });
                            google.charts.setOnLoadCallback(drawCharts);

                            function drawCharts() {
                                ColumnChart();
                                PieChart();
                            }

                            function ColumnChart() {
                                var data = google.visualization.arrayToDataTable([
                                    ['Task', 'Summary per product_type'],
                                    <?php echo $datax; ?>
                                ]);
                                var options = {
                                    title: 'Column Chart'
                                };

                                var chart = new google.visualization.ColumnChart(document.getElementById('ColumnChart'));
                                chart.draw(data, options);
                            }

                            function PieChart() {
                                var data = google.visualization.arrayToDataTable([
                                    ['Task', 'Summary per product_type'],
                                    <?php echo $datax; ?>
                                ]);

                                var options = {
                                    title: 'Pie Chart'
                                };

                                var chart = new google.visualization.PieChart(document.getElementById('PieChart'));
                                chart.draw(data, options);
                            }
                        </script>
                    </head>

                    <body>
                        <div style="display: flex; justify-content: space-between;">
                            <div id="ColumnChart" style="width: 48%; height: 300px;"></div>
                            <div id="PieChart" style="width: 48%; height: 300px;"></div>
                        </div>
                    </body>

                    </html>

                    <div class="card-body" style="height: 300px;">
                        <table class="table" table id="datatablesSimple" style="table-layout: fixed;">
                            <colgroup>
                                <col style="width: 5%;">
                                <col style="width: 25%;">
                                <col style="width: 25%;">
                            </colgroup>
                            <thead class="table-light">
                                <tr>
                                    <th>Product_id</th>
                                    <th>Product_name</th>
                                    <th>Category_name</th>
                                    <th>Product_quantity</th>
                                    <th>Shop_name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql_detail = "SELECT * FROM Product_detail
                                inner join product on product_detail.Product_id = product.Product_id
                                inner join product_category on product.Category_id = product_category.Category_id
                                INNER JOIN shop on product_detail.shop_id = shop.Shop_id";
                                $query_detail = mysqli_query($Connection, $sql_detail);

                                while ($row = mysqli_fetch_array($query_detail)) :
                                ?>
                                    <tr>
                                        <td><?php echo $row['Product_id']; ?></td>
                                        <td><?php echo $row['Product_name']; ?></td>
                                        <td><?php echo $row['Category_name']; ?></td>
                                        <td><?php echo $row['Product_quantity']; ?></td>
                                        <td><?php echo $row['Shop_name']; ?></td>

                                    </tr>
                                <?php endwhile ?>
                            </tbody>
                            <br>
                        </table>

                    </div>

                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>

</html>