<?php
require_once('connections/mysqli.php');
$sql_shop = "SELECT * FROM shop WHERE Shop_email = '" . $_SESSION['Shop_email'] . "'";
$query_shop = mysqli_query($Connection, $sql_shop);
$result_shop = mysqli_fetch_array($query_shop);

$sql_order = "SELECT max(Order_id) as Order_id, Order_status FROM order_main";
$query_order = mysqli_query($Connection, $sql_order);
$result_order = mysqli_fetch_array($query_order);
$Order_id = $result_order['Order_id'];

if (isset($_POST["submit_list"])) {

    $sql_product_check ="SELECT DISTINCT product.Product_name FROM product_detail 
    INNER JOIN product ON product_detail.Product_id = product.Product_id
    INNER JOIN Shop on product_detail.Shop_id = shop.Shop_id
    WHERE shop.Shop_email = '" . $_SESSION['Shop_email'] . "'
    AND product_detail.Product_detail_id = '" . $_POST["Product_detail_id"] . "'";
    $query_product_check = mysqli_query($Connection, $sql_product_check);
    $result_product_check = mysqli_fetch_array($query_product_check);
    $product_check_name = $result_product_check['Product_name'];

    $sql_check = "SELECT sub.Product_detail_id,sub.Product_quantity,sub.Product_name from (
        SELECT 
            COALESCE(SUM(DISTINCT product_detail.Product_quantity), 0) - COALESCE(SUM(detail.Detail_quantity), 0) as Product_quantity,
            product.Product_name,
            Shop_name,
            Category_name,
            product_detail.Product_detail_id,
            MAX(Order_status) AS Order_status                                    
        FROM 
            Product_detail
            INNER JOIN product ON product_detail.Product_id = product.Product_id
            INNER JOIN product_category ON product.Category_id = product_category.Category_id                                    
            INNER JOIN shop ON product_detail.Shop_id = shop.Shop_id
            LEFT JOIN detail ON detail.Product_detail_id = product_detail.Product_detail_id
            LEFT JOIN order_main ON detail.Order_id = order_main.Order_id
        WHERE 
            (shop.Shop_email = '" . $_SESSION['Shop_email'] . "' and ((order_main.Order_status = 'confirm' AND Product_name IS NOT NULL) 
            OR order_main.Order_status IS NULL OR order_main.Order_status = 'pending' OR order_main.Order_status = 'confirmed'))
        GROUP BY 
            Product_name, Category_name) as sub
            WHERE sub.Product_name = '$product_check_name'";
    $query_check = mysqli_query($Connection, $sql_check);
    $result_check = mysqli_fetch_array($query_check);

    $check_product_quantity = $result_check['Product_quantity'];
    $product_Detail_quantity = $_POST["Detail_quantity"];

    if ($check_product_quantity >  $product_Detail_quantity) {
        $sql_insert_detail = "INSERT INTO detail (Product_detail_id,Order_id,Detail_quantity) 
                    VALUES ('" . $_POST["Product_detail_id"] . "',$Order_id ,'" . $_POST["Detail_quantity"] . "')";
        $query = mysqli_query($Connection, $sql_insert_detail);
    } else {
        $message = "สินค้าในคลังไม่เพียงพอ ไม่สามารถเพิ่มรายการได้";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
}

if (isset($_POST["submit_pending"])) {

    $sql_update_order = "UPDATE order_main SET Order_status = 'pending', Order_address = '" . $_POST["Order_address"] . "' WHERE Order_id = $Order_id";
    $query_update_order = mysqli_query($Connection, $sql_update_order);

    $sql_insert_order = "INSERT INTO `order_main` (`Order_id`, `Order_status`) VALUES (NULL, 'waiting');";
    $query_insert_order = mysqli_query($Connection, $sql_insert_order);

    header("Refresh:0; url=shop_create_order.php");
}

if (isset($_POST["submit_cancel"])) {

    $sql_update_order = "UPDATE order_main SET Order_status = 'cancel', Order_address = '" . $_POST["Order_address"] . "' WHERE Order_id = $Order_id";
    $query_update_order = mysqli_query($Connection, $sql_update_order);

    $sql_insert_order = "INSERT INTO `order_main` (`Order_id`, `Order_status`) VALUES (NULL, 'waiting');";
    $query_insert_order = mysqli_query($Connection, $sql_insert_order);

    header("Refresh:0; url=shop_create_order.php");
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
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.php">Cloud Fulfillment</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <div class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0"></div>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">

                    <li><a class="dropdown-item"><?php echo $result_shop[3]; ?></a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="shop_information.php">แก้ไขข้อมูล</a></li>
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
                                <a class="nav-link" href="shop_create_order.php">Create Order</a>
                                <a class="nav-link" href="shop_order_history.php">Order History</a>
                            </nav>
                        </div>
                        <a class="nav-link" href="shop_inventory.php">Shop inventory</a>
                        <a class="nav-link" href="index.php">Dashboard</a>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseDownload" aria-expanded="false" aria-controls="collapseDownload">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Download
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseDownload" aria-labelledby="headingDownload" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="shop_export_indata.php">Inbound Data</a>
                                <a class="nav-link" href="shop_export_outdata.php">Outbound Data</a>
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
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Create Order</h1>

                    <form method="post">
                        <div class="row g-3 align-items-center">
                            <tr>
                                <td>
                                    <div class="col-auto">
                                        <label for="inputPassword6" class="col-form-label">Shop Name</label>
                                    </div>
                                    <div class="col-auto">
                                        <input type="text" class="form-control form-control-sm" value="<?php echo $result_shop[3]; ?>" placeholder="Enter Email" readonly required />
                                    </div>
                                </td>
                            </tr>
                        </div>

                        <div class="card">
                            <h5 class="card-header">Detail</h5>
                            <div class="card-body">

                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="inputGroup-sizing-default">Product Name</span>
                                    <select name="Product_detail_id" type="text" required class="form-control">
                                        <?php
                                        $sql_detail = "SELECT * FROM product_detail
                                        INNER JOIN product ON product_detail.Product_id = Product.Product_id
                                        INNER JOIN shop ON product_detail.Shop_id = shop.Shop_id                                                    
                                        WHERE Shop_email = '" . $_SESSION['Shop_email'] . "'
                                        GROUP by product_detail.Product_id";

                                        $query_detail = mysqli_query($Connection, $sql_detail);
                                        while ($result_detail = mysqli_fetch_array($query_detail)) {
                                        ?>
                                            <option value="<?= $result_detail['Product_detail_id']; ?>"><?= $result_detail['Product_name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="inputGroup-sizing-default">Quantity</span>
                                    <input type="text" class="form-control" name="Detail_quantity" placeholder="Enter quantity" required />
                                </div>

                                <label class="mb-3">
                                    <button type="submit" class="btn btn-success" name="submit_list">Add</button>
                                </label>
                            </div>


                        </div>
                    </form>
                    <br>

                    <form method="post">
                        <div class="row g-3 align-items-center">
                            <div class="col-auto">
                                <label for="inputPassword6" class="col-form-label">Address</label>
                            </div>
                            <div class="col-auto">
                                <input type="text" name="Order_address" class="form-control form-control-sm" placeholder="Enter Address" required />
                            </div>
                        </div>
                        <br>
                        <div class="card-body" style="height: 300px;">
                            <table class="table" id="datatablesSimple" style="table-layout: fixed;">
                                <colgroup>
                                    <col style="width: 5%;">
                                    <col style="width: 25%;">
                                    <col style="width: 25%;">
                                </colgroup>
                                <thead class="table-light">
                                    <tr>
                                        <th>Detail id</th>
                                        <th>ชื่อสินค้า</th>
                                        <th>จำนวน</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql_detail = "SELECT * FROM detail
                                    INNER JOIN product_detail ON product_detail.Product_detail_id = detail.Product_detail_id
                                    INNER JOIN product ON product.Product_id= product_detail.Product_id
                                    INNER JOIN order_main ON order_main.Order_id = detail.Order_id
                                    INNER JOIN shop ON shop.Shop_id = product_detail.Shop_id
                                    WHERE order_main.Order_id = $Order_id AND shop.Shop_email = '" . $_SESSION['Shop_email'] . "'";
                                    $query_detail = mysqli_query($Connection, $sql_detail);

                                    while ($row = mysqli_fetch_array($query_detail)) :
                                    ?>
                                        <tr>
                                            <td><?php echo $row['Detail_id']; ?></td>
                                            <td class="name"><?php echo $row['Product_name']; ?></td>
                                            <td><?php echo $row['Detail_quantity']; ?></td>
                                        </tr>
                                    <?php endwhile ?>
                                </tbody>
                            </table>

                            <button type="submit" class="btn btn-success" name="submit_pending">Confirm</button>
                            <button type="submit" class="btn btn-danger" name="submit_cancel">Cancel</button>
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