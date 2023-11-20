<?php
require_once('connections/mysqli.php');

$sql_admin = "SELECT * FROM `admin` WHERE Admin_user = '" . $_SESSION['Admin_user'] . "'";
$query_admin = mysqli_query($Connection, $sql_admin);
$result_admin = mysqli_fetch_array($query_admin);

if (isset($_POST["submit_del"])) {
    $sql_detail = "SELECT * FROM detail";
    $query_detail = mysqli_query($Connection, $sql_detail);
    $result_detail = mysqli_fetch_array($query_detail);

    if ($_POST["submit_del"] == $result_detail['Product_detail_id']) {
        $message = "ไม่สามารถลบได้ สินค้านี้ร้านค้าได้ส่งคำสั่งจัดส่งแล้ว";
        echo "<script type='text/javascript'>alert('$message');</script>";
    } else {
        $sql_product_detail = "DELETE FROM product_detail WHERE Product_detail_id = '" . $_POST["submit_del"] . "'";
        $query = mysqli_query($Connection, $sql_product_detail);
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
                                <a class="nav-link" href="admin_product.php">Product Category</a>
                                <a class="nav-link" href="admin_category.php">Category Management</a>
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
                    <h1 class="mt-4">Total Inventory</h1>
                    <form method="post">
                        <h5 class="card-header" style="text-align: center;">รายการสินค้าในคลังสินค้า</h5>

                        <div class="card-body" style="height: 300px;">
                            <table class="table" table id="datatablesSimple" style="table-layout: fixed;">
                                <colgroup>
                                    <col style="width: 5%;">
                                    <col style="width: 25%;">
                                    <col style="width: 25%;">
                                </colgroup>
                                <thead class="table-light">
                                    <tr>                                        
                                        <th>Product_name</th>
                                        <th>Product_quantity</th>                                          
                                        <th>Order_status</th>                               
                                        <th>Shop_name</th>
                                       

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql_detail = "SELECT 
                                    COALESCE(SUM(DISTINCT product_detail.Product_quantity), 0) - COALESCE(SUM(Detail_quantity), 0) as Product_quantity,
                                    Product_name,
                                    Category_name,
                                    MAX(Order_status) AS Order_status,
                                    MAX(Shop_name) AS Shop_name 
                                FROM 
                                    Product_detail
                                    INNER JOIN product ON product_detail.Product_id = product.Product_id
                                    INNER JOIN product_category ON product.Category_id = product_category.Category_id
                                    INNER JOIN shop ON product_detail.shop_id = shop.Shop_id
                                    LEFT JOIN detail ON detail.Product_detail_id = product_detail.Product_detail_id
                                    LEFT JOIN order_main ON detail.Order_id = order_main.Order_id
                                WHERE 
                                    (order_main.Order_status = 'confirm' AND Product_name IS NOT NULL) OR order_main.Order_status IS NULL
                                GROUP BY 
                                    Product_name, Category_name;
                                
                                ";                                      
                                                    
                                    $query_detail = mysqli_query($Connection, $sql_detail);

                                    while ($row = mysqli_fetch_array($query_detail)) :
                                    ?>
                                        <tr>                                            
                                            <td><?php echo $row['Product_name']; ?></td>
                                            <td><?php echo $row['Product_quantity']?></td>                                              
                                            <td><?php echo $row['Order_status']; ?></td> 
                                            <td><?php echo $row['Shop_name']; ?></td>

                                            
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