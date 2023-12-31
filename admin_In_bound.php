<?php
require_once('connections/mysqli.php');

$sql_admin = "SELECT * FROM `admin` WHERE Admin_user = '" . $_SESSION['Admin_user'] . "'";
$query_admin = mysqli_query($Connection, $sql_admin);
$result_admin = mysqli_fetch_array($query_admin);
$Admin_id = $result_admin['Admin_id'];
if (isset($_POST["submit_product"])) {

    $sql_insert_product = "INSERT INTO product_detail (Admin_id, Shop_id, Warehouse_id, Product_quantity, Product_id) 
                            VALUES ($Admin_id, " . $_POST["Shop_id"] . "," . $_POST["Warehouse_id"] . ",
                            " . $_POST["Product_quantity"] . ",'" . $_POST["Product_id"] . "')";

    $query_insert_product = mysqli_query($Connection, $sql_insert_product);
}


?>
<!DOCTYPE html>
<html lang="en">

<!-- Tab บน -->

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

                        <div>
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="admin_dashboard.php">Dashboard</a>

                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseProduct" aria-expanded="false" aria-controls="collapseProduct">
                                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                    Product
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="collapseProduct" aria-labelledby="headingProduct" data-bs-parent="#sidenavAccordion">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="admin_in_bound.php">Inbound</a>
                                        <a class="nav-link" href="admin_product.php">Add Product</a>
                                        <a class="nav-link" href="admin_category.php">Add Category</a>
                                    </nav>
                                </div>

                                <a class="nav-link" href="admin_inventory.php">Inventory</a>
                                <a class="nav-link" href="admin_order.php">Order</a>

                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseDownload" aria-expanded="false" aria-controls="collapseDownload">
                                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                    Download
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="collapseDownload" aria-labelledby="headingDownload" data-bs-parent="#sidenavAccordion">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="admin_export_indata.php">Inbound Data</a>
                                        <a class="nav-link" href="admin_export_outdata.php">Outbound Data</a>
                                    </nav>
                                </div>
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
                    <h1 class="mt-4">Inbound</h1>

                    <form method="post">

                        <div class="card">
                            <h5 class="card-header">Adding Product in the Warehouse</h5>
                            <div class="card-body">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="inputGroup-sizing-default">Shop</span>
                                    <select name="Shop_id" type="text" required class="form-control">
                                        <?php
                                        $sql_shop = "SELECT * FROM shop";
                                        $query_shop = mysqli_query($Connection, $sql_shop);
                                        while ($result_shop = mysqli_fetch_array($query_shop)) {
                                        ?>
                                            <option value="<?= $result_shop['Shop_id'] ?>"><?= $result_shop['Shop_name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="inputGroup-sizing-default">Warehouse</span>
                                    <select name="Warehouse_id" type="text" required class="form-control">
                                        <?php
                                        $sql_warehouse = "SELECT * FROM warehouse";
                                        $query_warehouse = mysqli_query($Connection, $sql_warehouse);
                                        while ($result_warehouse = mysqli_fetch_array($query_warehouse)) {
                                        ?>
                                            <option value="<?= $result_warehouse['Warehouse_id'] ?>"><?= $result_warehouse['Warehouse_zone'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="inputGroup-sizing-default">Product name</span>
                                    <select name="Product_id" type="text" required class="form-control">
                                        <?php
                                        $sql_product = "SELECT * FROM product";
                                        $query_product = mysqli_query($Connection, $sql_product);
                                        while ($result_product = mysqli_fetch_array($query_product)) {
                                        ?>
                                            <option value="<?= $result_product['Product_id'] ?>"><?= $result_product['Product_name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="inputGroup-sizing-default">Product Quantity</span>
                                    <input type="text" class="form-control" name="Product_quantity" placeholder="Enter quantity" required />
                                </div>

                                <label class="mb-3">
                                    <button type="submit" class="btn btn-success" name="submit_product">Add</button>
                                </label>

                            </div>
                        </div>
                    </form>
                    <br>


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