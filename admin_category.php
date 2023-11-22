<?php
require_once('connections/mysqli.php');

$sql_admin = "SELECT * FROM `admin` WHERE Admin_user = '" . $_SESSION['Admin_user'] . "'";
$query_admin = mysqli_query($Connection, $sql_admin);
$result_admin = mysqli_fetch_array($query_admin);
$Admin_id = $result_admin['Admin_id'];
if (isset($_POST["add_category"])) {
    $sql_insert_category = "INSERT INTO product_category (`Category_id`, `Category_name`) VALUES (NULL, '" . $_POST["Category_name"] . "');";
    $query_insert_category = mysqli_query($Connection, $sql_insert_category);
}

if (isset($_POST["del_category"])) {
    $delCategoryId = $_POST["del_category"];

    // Check if there are any products with the specified category
    $sql_product = "SELECT COUNT(*) as productCount FROM product WHERE Category_id = '$delCategoryId'";
    $query_product = mysqli_query($Connection, $sql_product);
    $result_product = mysqli_fetch_array($query_product);

    $productCount = $result_product['productCount'];

    if ($productCount > 0) {
        $message = "ไม่สามารถลบได้ เนื่องจากมีสินค้าที่ใช้งานอยู่ในหมวดหมู่นี้";
        echo "<script type='text/javascript'>alert('$message');</script>";
    } else {
        $sql_del_category = "DELETE FROM product_category WHERE Category_id = '$delCategoryId'";
        $query_del_category = mysqli_query($Connection, $sql_del_category);
    }
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
        <div class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0"></div>
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
                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                    Product
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="admin_in_bound.php">Inbound</a>
                                        <a class="nav-link" href="admin_product.php">Add Product</a>
                                        <a class="nav-link" href="admin_category.php">Add Category</a>
                                    </nav>
                                </div>

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
                    <h1 class="mt-4">Add Category</h1>
                    <br>
                    <form method="post">
                        <div class="card">
                            <h5 class="card-header">Add Category</h5>
                            <div class="card-body">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="inputGroup-sizing-default">Category</span>
                                    <input type="text" class="form-control" name="Category_name" placeholder="Enter Category" required />
                                </div>

                                <label class="mb-3">
                                    <button type="submit" name="add_category" class="btn btn-primary">Add</button>
                                </label>
                            </div>
                        </div>
                    </form>
                    <br>
                    <form method="post">

                        <div class="card-body" style="height: 300px;">
                            <table class="table" table id="datatablesSimple" style="table-layout: fixed;">
                                <colgroup>
                                    <col style="width: 5%;">
                                    <col style="width: 25%;">
                                    <col style="width: 25%;">
                                </colgroup>
                                <thead class="table-light">
                                    <tr>
                                        <th>Category_id</th>
                                        <th>Category_name</th>
                                        <th>ลบ</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql_category = "SELECT * FROM Product_category";
                                    $query_category = mysqli_query($Connection, $sql_category);

                                    while ($row = mysqli_fetch_array($query_category)) :
                                    ?>
                                        <tr>
                                            <td><?php echo $row['Category_id']; ?></td>
                                            <td><?php echo $row['Category_name']; ?></td>
                                            <td>
                                                <!-- Delete Button -->
                                                <button type="submit" name="del_category" value=<?php echo $row['Category_id']; ?> class="btn btn-danger btn-sm">Delete</button>
                                            </td>
                                        </tr>
                                    <?php endwhile ?>
                                </tbody>
                            </table>

                        </div>
                    </form>
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