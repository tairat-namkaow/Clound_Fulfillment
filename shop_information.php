<?php
require_once('connections/mysqli.php');

$sql_shop = "SELECT * FROM Shop WHERE Shop_email = '" . $_SESSION['Shop_email'] . "'";
$query_shop = mysqli_query($Connection, $sql_shop);
$result_shop = mysqli_fetch_array($query_shop);

$Shop_name = "";
$Shop_address = "";
$Shop_tel = "";
$Shop_email = "";

if (isset($_POST["Update_shop"])) {

    $sql_update_shop = "UPDATE shop SET Shop_name = '" . $_POST["Shop_name"] . "', 
                        Shop_address = '" . $_POST["Shop_address"] . "', 
                        Shop_tel = '" . $_POST["Shop_tel"] . "'
                        WHERE Shop_email = '" . $_SESSION['Shop_email'] . "' ";
    $query = mysqli_query($Connection, $sql_update_shop);
    header("Refresh:0; url=shop_information.php");
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
    <title>Clound_Fulfillment</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.php">Clound Fulfillment</a>
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

                    <li><a class="dropdown-item" href="#!"><?php echo $result_shop[3]; ?></a></li>
                    <li><hr class="dropdown-divider" /></li>
                    <li><a class="dropdown-item" href="shop_information.php">แก้ไขข้อมูล</a></li>
                    <li><hr class="dropdown-divider" /></li>
                    <li><button class="dropdown-item" type="button" onclick="window.location.href='logout.php'">ออกจากระบบ</button></li>
                </ul>
            </li>
        </ul>
    </nav>
    <br>
    <!-- Tab ซ้าย -->
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
                                <a class="nav-link" href="shop_create_order.php">Create Order</a>
                                <a class="nav-link" href="shop_order_history.php">Order History</a>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    <?php echo $result_shop[3]; ?>
                </div>
            </nav>
        </div>


        <!-- หน้าต่าง Shop Information -->
        <div id="layoutSidenav_content">
            <!DOCTYPE html>
            <html lang="en">

            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Card with Rounded Borders</title>
                <style>
                    .card {
                        background-color: white;
                        border: 3px solid #000;
                        border-radius: 20px;
                        margin-bottom: 4px;
                        padding: 0.5rem 1rem;
                    }
                </style>
            </head>

            <body>
                <main>
                    <div class="container-fluid px-4">
                        <div class="card">
                            <div class="card-header">
                                <h1 class="mt-4">Shop Information</h1>
                            </div>
                            <div class="card-body">
                                <ol class="breadcrumb mb-4">

                                </ol>

                            </div>

                            <section class="section">
                                <div class="row">
                                    <div class="col-lg-12">

                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title"><b>ข้อมูลร้านค้า</b></h5>

                                                <form method="post">
                                                    <br>
                                                    <br>
                                                    <div class="row mb-3">
                                                        <label for="inputText" class="col-sm-2 col-form-label">Shop Name</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" name="Shop_name" value="<?php echo $result_shop['Shop_name'] ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="inputText" class="col-sm-2 col-form-label">Shop Address</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" name="Shop_address" value="<?php echo $result_shop['Shop_address'] ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="inputText" class="col-sm-2 col-form-label">Telephone</label>
                                                        <div class="col-sm-10">
                                                            <input type="number" class="form-control" name="Shop_tel" value="<?php echo $result_shop['Shop_tel'] ?>">
                                                        </div>
                                                    </div>

                                                    <!-- Update button -->
                                                    <div class="col-sm-2">
                                                        <button type="submit" name="Update_shop" class="btn btn-primary">Update</button>
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