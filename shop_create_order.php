<?php
require_once('connections/mysqli.php');
$sql_shop = "SELECT * FROM shop WHERE Shop_email = '" . $_SESSION['Shop_email'] . "'";
$query_shop = mysqli_query($Connection, $sql_shop);
$result_shop = mysqli_fetch_array($query_shop);

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

    $sql_update_order = "UPDATE order_main SET Order_status = 'confirm', Order_address = '" . $_POST["Order_address"] . "' WHERE Order_id = $Order_id";
    $query_update_order = mysqli_query($Connection, $sql_update_order);


    $sql_insert_order = "INSERT INTO `order_main` (`Order_id`, `Order_status`) VALUES (NULL, 'pending');";
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
        <a class="navbar-brand ps-3" href="index.php">Clound Fulfillment</a>
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
                    <li><hr class="dropdown-divider" /></li>
                    <li><a class="dropdown-item" href="shop_information.php">แก้ไขข้อมูล</a></li>
                    <li><hr class="dropdown-divider" /></li>
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
                        <a class="nav-link" href="shop_information.php">Information</a>
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
                        <a class="nav-link" href=".php">Dashboard รอเพิ่มลิงค์</a>

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

                                    <select name="Product_id" type="text" required class="form-control">
                                        <?php
                                        $sql_detail = "SELECT * FROM product
                                        inner join shop on product.Shop_id = shop.Shop_id
                                        inner join product_category on product.Category_id = product_category.Category_id 
                                        WHERE Shop_email = '" . $_SESSION['Shop_email'] . "'";
                                        $query_detail = mysqli_query($Connection, $sql_detail);
                                        while ($result_detail = mysqli_fetch_array($query_detail)) {
                                        ?>
                                            <option value="<?= $result_detail['Product_id'] ?>"><?= $result_detail['Category_name'] ?></option>
                                        <?php } ?>
                                    </select>

                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="inputGroup-sizing-default">Quantity</span>

                                    <input type="text" class="form-control" name="Detail_quantity" placeholder="Enter quantity" required />
                                </div>

                                <label class="mb-3">
                                    <button type="submit" class="btn btn-success" name="submit_order">Add</button>
                                </label>

                            </div>
                        </div>
                    </form>
                    <br>

                    <form method="post">
                        <h5 class="card-header" style="text-align: center;">รายการสินค้า</h5>
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
                INNER JOIN product ON product.Product_id = detail.Product_id
                INNER JOIN product_category ON product.Category_id = product_category.Category_id 
                INNER JOIN order_main ON order_main.Order_id = detail.Order_id
                INNER JOIN shop ON shop.Shop_id = product.Shop_id
                WHERE order_main.Order_id = $Order_id AND shop.Shop_email = '" . $_SESSION['Shop_email'] . "'";
                                    $query_detail = mysqli_query($Connection, $sql_detail);

                                    while ($row = mysqli_fetch_array($query_detail)) :
                                    ?>
                                        <tr>
                                            <td><?php echo $row['Detail_id']; ?></td>
                                            <td class="name"><?php echo $row['Category_name']; ?></td>
                                            <td><?php echo $row['Detail_quantity']; ?></td>
                                        </tr>
                                    <?php endwhile ?>
                                </tbody>
                            </table>

                            <button type="submit" class="btn btn-success" name="submit_status">Confirm</button>
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