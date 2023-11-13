<?php
require_once('connections/mysqli.php');

$sql_admin = "SELECT * FROM `admin` WHERE Admin_user = '" . $_SESSION['Admin_user'] . "'";
$query_admin = mysqli_query($Connection, $sql_admin);
$result_admin = mysqli_fetch_array($query_admin);

if (isset($_POST["submit_cf"])) {
    $orderId = $_POST["submit_cf"];
    $sql_update = "UPDATE order_main SET Order_status = 'Confirmed' WHERE Order_id = '$orderId' AND Order_status = 'Pending'";
    $query_update = mysqli_query($Connection, $sql_update);

    if ($query_update) {
        $message = "The order has been confirmed";
        echo "<script type='text/javascript'>alert('$message');</script>";
    } else {
        $message = "Failed to confirm the order";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
}

if (isset($_POST["submit_cc"])) {
    $orderId = $_POST["submit_cc"];
    $sql_update = "UPDATE order_main SET Order_status = 'Cancelled' WHERE Order_id = '$orderId' AND Order_status = 'Pending'";
    $query_update = mysqli_query($Connection, $sql_update);

    if ($query_update) {
        $message = "The order has been cancelled";
        echo "<script type='text/javascript'>alert('$message');</script>";
    } else {
        $message = "Failed to cancel the order";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
}
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
        <a class="navbar-brand ps-3" href="index.php">Admin Dashboard</a>
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
                            Order
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="admin_dashboard.php">Dashboard</a>
                                <a class="nav-link" href="">In-bound</a>
                                <a class="nav-link" href="">Inventory</a>
                                <a class="nav-link" href="">Order</a>
                                <a class="nav-link" href="">Shop</a>
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
                    <h1 class="mt-4">Admin Order</h1>
                    <form method="post">
                        <h5 class="card-header" style="text-align: center;">รายการคำสั่ง</h5>

                        <div class="card-body" style="height: 300px;">
                            <table class="table" table id="datatablesSimple" style="table-layout: fixed;">
                                <colgroup>
                                    <col style="width: 5%;">
                                    <col style="width: 25%;">
                                    <col style="width: 25%;">
                                </colgroup>
                                <thead class="table-light">
                                    <tr>
                                        <th>Order_id</th>
                                        <th>Shop_id</th>
                                        <th>Order_status</th>
                                        <th>Order_date</th>
                                        <th>Detail</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql_adorder = "SELECT * FROM order_main
                                                    inner join detail on order_main.Order_id = detail.Order_id
                                                    inner join product on detail.product_id = Product.Product_id
                                                    inner join shop on product.Shop_id = shop.Shop_id";

                                    $query_adorder = mysqli_query($Connection, $sql_adorder);

                                    while ($row = mysqli_fetch_array($query_adorder)) :
                                    ?>
                                        <tr>
                                            <td><?php echo $row['Order_id']; ?></td>
                                            <td><?php echo $row['Shop_id']; ?></td>
                                            <td><?php echo $row['Order_status']; ?></td>
                                            <td><?php echo $row['Order_date']; ?></td>

                                            <!-- detail Button -->

                                            <td><a href='Order-Details.php?orderId=" . htmlspecialchars(<?php echo $row['Order_id']; ?>) . "' class='btn btn-primary btn-sm'>Detail</a></td>

                                            <td>
                                                <!-- cf/cc Button -->
                                                <button type="submit" name="submit_cf" value=<?php echo $row['Order_id']; ?> class="btn btn-success btn-sm">Confirm</button>
                                                <button type="submit" name="submit_cc" value=<?php echo $row['Order_id']; ?> class="btn btn-danger btn-sm">Cancel</button>
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