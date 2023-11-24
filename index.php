<?php
require_once('connections/mysqli.php');

$sql_shop = "SELECT * FROM Shop WHERE Shop_email = '" . $_SESSION['Shop_email'] . "'";
$query_shop = mysqli_query($Connection, $sql_shop);
$result_shop = mysqli_fetch_array($query_shop);

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
    <title>Cloud Fulfillment</title>
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

                    <li><a class="dropdown-item" href="#!"><?php echo $result_shop[3]; ?></a></li>
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
                    <h1 class="mt-4">Shop Dashboard</h1>
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <?php
                                $sql_time = "SELECT count(*) as total FROM detail
                                inner join product_detail on product_detail.Product_detail_id = detail.Product_detail_id
                                INNER join shop on product_detail.Shop_id = shop.Shop_id
                                WHERE Product_time_add = curdate() and shop.Shop_email = '" . $_SESSION['Shop_email'] . "'";
                                $query_time = mysqli_query($Connection, $sql_time);
                                $result_time = mysqli_fetch_array($query_time);
                                ?>
                                <div class="card-body">Inbound</div>
                                <div class="card-footer d-flex align-items-center">
                                    <a>สินค้าของร้านเข้าคลังวันนี้ จำนวน : <?php echo $result_time['total'] ?> รายการ</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-warning text-white mb-4">
                                <?php
                                $sql_pending = "SELECT COUNT(DISTINCT order_main.Order_id) AS pending
                                FROM `detail`
                                INNER JOIN product_detail ON product_detail.Product_detail_id = detail.Product_detail_id
                                INNER JOIN shop ON product_detail.Shop_id = shop.Shop_id
                                INNER JOIN order_main ON detail.Order_id = order_main.Order_id
                                WHERE order_main.Order_status = 'pending' AND shop.Shop_email = '" . $_SESSION['Shop_email'] . "'";

                                $query_pending = mysqli_query($Connection, $sql_pending);
                                $result_pending = mysqli_fetch_array($query_pending);

                                $sql_confirm = "SELECT COUNT(DISTINCT order_main.Order_id) AS confirm
                                FROM `detail`
                                INNER JOIN product_detail ON product_detail.Product_detail_id = detail.Product_detail_id
                                INNER JOIN shop ON product_detail.Shop_id = shop.Shop_id
                                INNER JOIN order_main ON detail.Order_id = order_main.Order_id
                                WHERE order_main.Order_status = 'confirm' AND shop.Shop_email = '" . $_SESSION['Shop_email'] . "'";
                                $query_confirm = mysqli_query($Connection, $sql_confirm);
                                $result_confirm = mysqli_fetch_array($query_confirm);
                                ?>
                                <div class="card-body">Order Status</div>
                                <div class="card-footer d-flex align-items-center">
                                    <a style="margin-right: 10px;">Pending: <?php echo $result_pending['pending'] ?> รายการ</a>
                                    <a style="margin-right: 10px;">Confirm: <?php echo $result_confirm['confirm'] ?> รายการ</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-success text-white mb-4">
                                <?php
                                $sql_sku = "SELECT COUNT(DISTINCT product.Product_name) AS sku
                                FROM product_detail
                                INNER JOIN shop ON product_detail.Shop_id = shop.Shop_id
                                INNER JOIN product ON product_detail.Product_id = product.Product_id                                
                                WHERE shop.Shop_email = '" . $_SESSION['Shop_email'] . "'";
                                $query_sku = mysqli_query($Connection, $sql_sku);
                                $result_sku = mysqli_fetch_array($query_sku);
                                ?>
                                <div class="card-body">Inventory</div>
                                <div class="card-footer d-flex align-items-center">
                                    <a>สินค้าคงคลังในระบบ จำนวน : <?php echo $result_sku['sku'] ?> SKU</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-danger text-white mb-4">
                                <?php
                                $sql_shop = "SELECT count(*) as Out_bound FROM detail 
                                INNER JOIN order_main on detail.Order_id = order_main.Order_id
                                inner join product_detail on detail.Product_detail_id = product_detail.Product_detail_id
                                INNER join shop on product_detail.Shop_id = shop.Shop_id
                                WHERE order_main.Order_status = 'confirm' and detail.Detail_date = curdate() and shop.Shop_email = 
                                 '" . $_SESSION['Shop_email'] . "'";

                                $query_shop = mysqli_query($Connection, $sql_shop);
                                $result_shop = mysqli_fetch_array($query_shop);
                                ?>
                                <div class="card-body">Outbound</div>
                                <div class="card-footer d-flex align-items-center">
                                    <a>สินค้าของร้านออกคลังวันนี้ จำนวน : <?php echo $result_shop['Out_bound'] ?> รายการ</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                    $sql_combined = "SELECT 
                    sub.Category_name,
                    SUM(DISTINCT sub.in_quantity) AS in_quantity,
                    SUM(DISTINCT sub.out_quantity) AS out_quantity 
                FROM
                    (	
                        SELECT 
                            SUM(DISTINCT product_detail.Product_quantity) AS in_quantity, 
                            SUM(DISTINCT detail.Detail_quantity) AS out_quantity,
                            Product.Product_name,
                            Product.Product_id,
                            product_category.Category_name,
                            shop.Shop_email,
                            MAX(order_main.Order_status) AS Order_status                                    
                        FROM 
                            Product_detail
                            INNER JOIN product ON product_detail.Product_id = product.Product_id
                            INNER JOIN product_category ON product.Category_id = product_category.Category_id                                    
                            LEFT JOIN detail ON detail.Product_detail_id = product_detail.Product_detail_id
                            LEFT JOIN order_main ON detail.Order_id = order_main.Order_id
                            INNER JOIN shop ON product_detail.Shop_id = shop.Shop_id
                        WHERE 
                            ((order_main.Order_status = 'confirm' AND Product.Product_name IS NOT NULL) 
                            OR order_main.Order_status IS NULL 
                            OR order_main.Order_status IN ('pending', 'confirmed'))
                            AND shop.Shop_email = '" . $_SESSION['Shop_email'] . "'
                        GROUP BY 
                            Product.Product_name, 
                            Product.Product_id,
                            product_category.Category_name,
                            shop.Shop_email
                    ) AS sub
                GROUP BY 
                    sub.Category_name;                                
                ";


                    // Execute the SQL query
                    $query_combined = mysqli_query($Connection, $sql_combined);

                    // Fetch the data and format it for Chart.js
                    $chartData = array();
                    while ($row = mysqli_fetch_assoc($query_combined)) {
                        $chartData[] = array(
                            'date' => $row['Category_name'], // Assuming order_month is the label for the x-axis
                            'in_quantity' => $row['in_quantity'],
                            'out_quantity' => $row['out_quantity']
                        );
                    }

                    // Convert PHP array to JSON for JavaScript
                    $json_data = json_encode($chartData);
                    ?>

                    <!-- Include a JavaScript library for charts, such as Chart.js -->
                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

                    <!-- Create a canvas element to render the chart -->
                    <canvas id="myChart" width="400" height="100"></canvas>

                    <script>
                        // Parse the JSON data
                        var chartData = <?php echo $json_data; ?>;

                        // Extract labels and data for the chart
                        var labels = chartData.map(function(item) {
                            return item.date;
                        });

                        var inQuantityData = chartData.map(function(item) {
                            return item.in_quantity;
                        });

                        var outQuantityData = chartData.map(function(item) {
                            return item.out_quantity;
                        });

                        // Create a chart using Chart.js
                        var ctx = document.getElementById('myChart').getContext('2d');
                        var myChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'In Quantity',
                                    data: inQuantityData,
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 1
                                }, {
                                    label: 'Out Quantity',
                                    data: outQuantityData,
                                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                    borderColor: 'rgba(255, 99, 132, 1)',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                plugins: {
                                    title: {
                                        display: true,
                                        text: 'กราฟแสดงผลรวมสินค้า เข้า - ออก แต่ละประเภท',
                                        font: {
                                            size: 16
                                        }
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    </script>


                    <?php
                    $sql_combined2 = "SELECT 
                    product_category.Category_name AS Category_name, 
                    product.Product_name,
                    MONTH(order_main.Order_date) AS group_Month, 
                    SUM(DISTINCT product_detail.Product_quantity) AS in_quantity, 
                    SUM(detail.Detail_quantity) AS out_quantity, 
                    shop.Shop_email 
                FROM 
                    product_category
                    LEFT JOIN product ON product.Category_id = product_category.Category_id 
                    LEFT JOIN product_detail ON product_detail.Product_id = product.Product_id 
                    LEFT JOIN detail ON detail.Product_detail_id = product_detail.Product_detail_id 
                    LEFT JOIN order_main ON detail.Order_id = order_main.Order_id 
                    LEFT JOIN shop ON product_detail.Shop_id = shop.Shop_id 
                WHERE 
                    shop.Shop_email = '" . $_SESSION['Shop_email'] . "' and
                    ((order_main.Order_status = 'confirm' AND Product_name IS NOT NULL) 
                    OR order_main.Order_status IS NULL OR order_main.Order_status = 'pending' OR order_main.Order_status = 'confirmed')
                GROUP BY 
                    product_name, 
                    group_Month                                
                ";


                    // Execute the SQL query
                    $query_combined2 = mysqli_query($Connection, $sql_combined2);

                    // Fetch the data and format it for Chart.js
                    $chartData2 = array();
                    while ($row2 = mysqli_fetch_assoc($query_combined2)) {
                        $chartData2[] = array(
                            'date' => $row2['Product_name'], // Assuming order_month is the label for the x-axis
                            'in_quantity' => $row2['in_quantity'],
                            'out_quantity' => $row2['out_quantity']
                        );
                    }

                    // Convert PHP array to JSON for JavaScript
                    $json_data2 = json_encode($chartData2);
                    ?>

                    <!-- Include a JavaScript library for charts, such as Chart.js -->
                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

                    <!-- Create a canvas element to render the chart -->
                    <canvas id="myChart2" width="400" height="100"></canvas>

                    <script>
                        // Parse the JSON data for the second chart
                        var chartData2 = <?php echo $json_data2; ?>;

                        // Extract labels and data for the second chart
                        var labels2 = chartData2.map(function(item) {
                            return item.date;
                        });

                        var inQuantityData2 = chartData2.map(function(item) {
                            return item.in_quantity;
                        });

                        var outQuantityData2 = chartData2.map(function(item) {
                            return item.out_quantity;
                        });

                        // Create the second chart using Chart.js
                        var ctx2 = document.getElementById('myChart2').getContext('2d');
                        var myChart2 = new Chart(ctx2, {
                            type: 'bar',
                            data: {
                                labels: labels2,
                                datasets: [{
                                    label: 'In Quantity',
                                    data: inQuantityData2,
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 1
                                }, {
                                    label: 'Out Quantity',
                                    data: outQuantityData2,
                                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                    borderColor: 'rgba(255, 99, 132, 1)',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                plugins: {
                                    title: {
                                        display: true,
                                        text: 'กราฟแสดงผลรวมสินค้า เข้า - ออก แต่ละชนิด',
                                        font: {
                                            size: 16
                                        }
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    </script>
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
                <th>Product_name</th>
                <th>Category_name</th>
                <th>Product_quantity</th>

            </tr>
        </thead>
        <tbody>
            <?php
            $sql_detail = "SELECT 
                                    COALESCE(SUM(DISTINCT product_detail.Product_quantity), 0) - COALESCE(SUM(detail.Detail_quantity), 0) as Product_quantity,
                                    product.Product_name,
                                    Shop_name,
                                    Category_name,
                                    MAX(Order_status) AS Order_status                                    
                                FROM 
                                    Product_detail
                                    INNER JOIN product ON product_detail.Product_id = product.Product_id
                                    INNER JOIN product_category ON product.Category_id = product_category.Category_id                                    
                                    INNER JOIN shop ON product_detail.Shop_id = shop.Shop_id
                                    LEFT JOIN detail ON detail.Product_detail_id = product_detail.Product_detail_id
                                    LEFT JOIN order_main ON detail.Order_id = order_main.Order_id
                                WHERE 
                                    shop.Shop_email = '" . $_SESSION['Shop_email'] . "' and ((order_main.Order_status = 'confirm' AND Product_name IS NOT NULL) 
                                    OR order_main.Order_status IS NULL OR order_main.Order_status = 'pending' OR order_main.Order_status = 'confirmed')
                                GROUP BY 
                                    Product_name, Category_name;";

            $query_detail = mysqli_query($Connection, $sql_detail);

            while ($row = mysqli_fetch_array($query_detail)) :
            ?>
                <tr>
                    <td><?php echo $row['Product_name']; ?></td>
                    <td><?php echo $row['Category_name']; ?></td>
                    <td><?php echo $row['Product_quantity'] ?></td>
                </tr>
            <?php endwhile ?>
        </tbody>
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