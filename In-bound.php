<?php
require_once('connections/mysqli.php');

$sql_order = "SELECT max(Order_id) as Order_id, Order_status FROM order_main";
$query_order = mysqli_query($Connection, $sql_order);
$result_order = mysqli_fetch_array($query_order);
$Order_id = $result_order['Order_id'];

if (isset($_POST["submit_order"])) {

    $sql_insert_detail = "INSERT INTO detail (Product_id,Order_id,Detail_quantity) 
                VALUES ('" . $_POST["Product_id"] . "',$Order_id ,'" . $_POST["Detail_quantity"] . "')";
    $query = mysqli_query($Connection, $sql_insert_detail);
}

if (isset($_POST["submit_status"])) {
    
    $sql_update_order = "UPDATE order_main SET Order_status = 'confirm' WHERE Order_id = $Order_id";
    $query_update_order = mysqli_query($Connection, $sql_update_order);

    $sql_insert_order = "INSERT INTO `order_main` (`Order_id`, `Order_status`) VALUES (NULL, 'pending');";
    $query_insert_order = mysqli_query($Connection, $sql_insert_order);
}

?>

<?php
require_once('connections/mysqli.php');

$sql_OrderDetail = "SELECT * FROM `detail` 
inner join product on detail.Product_id = product.Product_id
inner join shop on product.Shop_id = shop.Shop_id
WHERE Shop_name = '" . $_SESSION['Shop_name'] . "'";
$query_OrderDetail = mysqli_query($Connection, $sql_OrderDetail);
$result_OrderDetail = mysqli_fetch_array($query_OrderDetail);
?>


<!-- Tab บน -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-white" bg-white">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.html" style="color: black;">Cloud Fulfillment</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars" style="color: black;"></i></button>
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

                    <li><a class="dropdown-item" href="#!"><?php echo $result_shop[2]; ?></a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><button class="dropdown-item" type="button" onclick="window.location.href='logout.php'">ออกจากระบบ</button></li>
                </ul>
            </li>
        </ul>
    </nav>









    <!-- Tab ซ้าย -->
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-white" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <a class="nav-link" href="charts.html">
                            <div class="sb-nav-link-icon"><i class=""></i></div>
                            <span style="color: black;">Dashboard</span>
                        </a>
                        <a class="nav-link" href="charts.html">
                            <div class="sb-nav-link-icon"><i class=""></i></div>
                            <span style="color: black;">In-Bound</span>
                        </a>
                        <a class="nav-link" href="charts.html">
                            <div class="sb-nav-link-icon"><i class=""></i></div>
                            <span style="color: black;">Inventory</span>
                        </a>
                        <a class="nav-link" href="charts.html">
                            <div class="sb-nav-link-icon"><i class=""></i></div>
                            <span style="color: black;">Order</span>
                        </a>
                        <a class="nav-link" href="charts.html">
                            <div class="sb-nav-link-icon"><i class=""></i></div>
                            <span style="color: black;">Shop</span>
                        </a>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class=""></i></div>
                            <span style="color: black;">Order</span>
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down" style="color: black;"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="layout-static.html" style="color: black;">Place Order</a>
                                <a class="nav-link" href="layout-sidenav-light.html" style="color: black;">Order History</a>
                            </nav>
                        </div>

                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseDownload" aria-expanded="false" aria-controls="collapseDownload">
                            <div class="sb-nav-link-icon"><i class=""></i></div>
                            <span style="color: black;">Download</span>
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down" style="color: black;"></i></div>
                        </a>
                        <div class="collapse" id="collapseDownload" aria-labelledby="headingDownload" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="layout-static.html" style="color: black;">Report Summary</a>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    <li><a class="dropdown-item" href="#!"><?php echo $result_shop[2]; ?></a></li>
                </div>
            </nav>
        </div>





        <!-- หน้าต่าง Order Details -->
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

                    .card-body {}

                    .card-header {}
                </style>
            </head>

            <body>
                <main>
                    <div class="container-fluid px-4">
                        <div class="card">
                            <div class="card-header">
                                <h1 class="mt-4">In-Bound</h1>
                            </div>
                            <div class="card-body">
                                <ol class="breadcrumb mb-4">

                                </ol>

                            </div>


                            <!-- หน้าต่าง ข้างใน Order Details -->

                            <div class="row">
                                <div class="col-12">
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
                                            }

                                            .card-body {
                                                padding: 0.5rem 1rem;
                                            }
                                        </style>
                                    </head>

                                    <body>

                                        <div class="card">
                                        <!DOCTYPE html>

                                        
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Product</title>
<style>
    /* Add your CSS styles here */
    body {
        font-family: Arial, sans-serif;
    }
    .container {
        width: 300px;
        margin: auto;
        border: solid 1px #ccc;
        padding: 20px;
        border-radius: 5px;
    }
    .form-input {
        margin-bottom: 10px;
    }
    .form-input label {
        display: block;
        margin-bottom: 5px;
    }
    .form-input input {
        width: 100%;
        padding: 5px;
        margin-bottom: 5px;
        border: solid 1px #ccc;
        border-radius: 3px;
    }
    .form-input input[type="button"] {
        background-color: black;
        color: white;
        border: none;
        cursor: pointer;
        padding: 10px 15px;
    }

    
    <style>
    .form-input, .input-group {
        width: 100%;
        margin-bottom: 15px;
    }

    .input-group-text, .form-control {
        width: 100%;
    }
</style>

<div class="container">
    
    <div class="form-input">
        <label for="shop-name">SHOP-NAME</label>
       
        <div class="input-group mb-3">
            <span class="input-group-text" id="inputGroup-sizing-default"/span>
            <select name="Shop_id" type="text" required class="form-control">
                <?php
                $sql_Shop = "SELECT * FROM `shop` ";
                $query_Shop = mysqli_query($Connection, $sql_Shop);
                while ($result_Shop = mysqli_fetch_array($query_Shop)) {
                    ?>
                    <option value="<?= $result_Shop['Shop_id'] ?>"><?= $result_Shop['Shop_name'] ?></option>
                <?php } ?>
            </select>
        </div>
        
    </div>
    <div class="form-input">
        <label for="product-name">PRODUCT-NAME</label>
        <input type="text" id="product-name" name="product-name">
    </div>
    <div class="form-input">
        <label for="quantity">QUANTITY</label>
        <input type="number" id="quantity" name="quantity">
    </div>
    <div class="form-input">
        <label for="expire-date">EXPIRE DATE</label>
        <input type="date" id="expire-date" name="expire-date">
    </div>
    <div class="form-input">
        <label for="zone">ZONE</label>
        <input type="text" id="zone" name="zone">
    </div>
    <input type="button" value="Confirm" onclick="confirmProduct()">
</div>


    <?php


?>                                           





                                        </div>

                                    </body>

                                    </html>
                                </div>
                                

                                </html>
                            </div>


                        </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>

                        </div>
                    </div>
                </footer>
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


















                              


                                