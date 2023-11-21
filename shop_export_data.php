<?php
// Database connection parameters
require_once('connections/mysqli.php');

$sql_shop = "SELECT * FROM shop WHERE Shop_email = '" . $_SESSION['Shop_email'] . "'";
$query_shop = mysqli_query($Connection, $sql_shop);
$result_shop = mysqli_fetch_array($query_shop);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get start date and end date from the form (validate and sanitize input)
    $startDate = mysqli_real_escape_string($Connection, $_POST['start_date']);
    $endDate = mysqli_real_escape_string($Connection, $_POST['end_date']);

    // Set the SQL query using prepared statements
    $sql_exp = "SELECT DISTINCT order_main.Order_id, order_main.Order_date,
                        product.Product_id, product.Product_name, 
                        shop.Shop_name, warehouse.Warehouse_zone, product_category.Category_name, detail.Detail_quantity
            FROM detail
                INNER JOIN order_main ON detail.Order_id = order_main.Order_id
                INNER JOIN product_detail ON detail.Product_detail_id = product_detail.Product_detail_id
                INNER JOIN shop ON product_detail.Shop_id = shop.Shop_id
                INNER JOIN product ON product.Product_id = product_detail.Product_id
                INNER JOIN product_category ON product_category.Category_id = product.Category_id
                INNER JOIN warehouse ON product_detail.Warehouse_id = warehouse.Warehouse_id
            WHERE order_main.Order_date BETWEEN ? AND ?
            ORDER BY order_main.Order_id";

    // Prepare and bind the statement
    $stmt = mysqli_prepare($Connection, $sql_exp);
    mysqli_stmt_bind_param($stmt, "ss", $startDate, $endDate);

    // Execute the query
    $query_exp = mysqli_stmt_execute($stmt);

    // Set the CSV filename
    $csv_filename = 'exported_data.csv';

    // Check if the query was successful
    if ($query_exp) {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $csv_filename . '"');

        // Open a file handle for writing to the CSV file
        $file = fopen('php://output', 'w');

        // Write headers to the CSV file
        $header = array('Order_id', 'Order_date', 'Product_id', 'Product_name', 'Shop_name', 'Warehouse_zone', 'Product_category', 'Quantity');
        fputcsv($file, $header);

        // Fetch and write data to the CSV file
        $result = mysqli_stmt_get_result($stmt);
        while ($row = mysqli_fetch_assoc($result)) {
            fputcsv($file, $row);
        }

        // Close the file handle
        fclose($file);

        // Exit to prevent further output
        exit;
    } else {
        echo "Error: " . mysqli_error($Connection);
    }

    // Close the statement
    mysqli_stmt_close($stmt);
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
        <a class="navbar-brand ps-3" href="index.php">Cloud Fulfillment</a>
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
                        <a class="nav-link" href="shop_export_data.php">Download</a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    <?php echo $result_shop['Shop_name']; ?>
                </div>
            </nav>
        </div>

        <!-- หน้าต่าง Export Data Summary -->
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
                        <br>
                        <div class="card">
                            <div>
                                <h1 class="mt-4">Export Data Summary</h1>
                            </div>
                            <div class="card-body">
                                <ol class="breadcrumb mb-4">
                                </ol>
                            </div>

                            <section class="section">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card" style="max-width: 400px; margin: auto; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                                            <div class="card-body">
                                                <h5 class="card-title text-center"><b>Data Period</b></h5>
                                            </div>
                                            <div class="card-body">
                                                <form method="post">
                                                    <div class="mb-3">
                                                        <label for="start_date" class="form-label">Start Date:</label>
                                                        <input type="date" name="start_date" class="form-control" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="end_date" class="form-label">End Date:</label>
                                                        <input type="date" name="end_date" class="form-control" required>
                                                    </div>

                                                    <button type="submit" class="btn btn-primary" style="border-radius: 5px; width: 100%;">Export Data</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <br>

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

</html>