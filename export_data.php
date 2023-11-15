<?php
// Database connection parameters
require_once('connections/mysqli.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get start date and end date from the form
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];

    // Set the CSV filename
    $csv_filename = 'exported_data.csv';

    // Set the SQL query to fetch data from your table
    $sql_exp = "SELECT order_main.Order_id, order_main.Order_date, shop.Shop_name, product.Product_id, product.Product_name, detail.Detail_quantity
FROM `detail`
INNER JOIN order_main ON detail.Order_id = order_main.Order_id
INNER JOIN product ON detail.Product_id = product.Product_id
INNER JOIN shop ON product.Shop_id = shop.Shop_id
WHERE order_main.Order_date BETWEEN '$startDate' AND '$endDate'";

    // Execute the query
    $query_exp = mysqli_query($Connection, $sql_exp);

    // Check if the query was successful
    if ($query_exp) {

        // Output CSV headers
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $csv_filename . '"');

        // Open a file handle for writing to the CSV file
        $file = fopen('php://output', 'w');

        // Write headers to the CSV file
        $header = array('Order_id', 'Order_date', 'Shop_name', 'Product_id', 'Product_name', 'Quantity'); // Replace with your actual column names
        fputcsv($file, $header);

        // Fetch and write data to the CSV file
        while ($row = mysqli_fetch_assoc($query_exp)) {
            fputcsv($file, $row);
        }

        // Close the file handle
        fclose($file);

        $message = "CSV file successfully created";
        echo "<script type='text/javascript'>alert('$message');</script>";
    } else {
        echo "Error: " . mysqli_error($connection);
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
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-white" bg-white>
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

                    <li><a class="dropdown-item"><?php echo $result_admin['Admin_user']; ?></a></li>
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
                            <span style="color: black;">Admin Information</span>
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
                                <a class="nav-link" href="layout-static.html" style="color: black;">Export Data Summary</a>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    <li><a class="dropdown-item"><?php echo $result_admin['Admin_user']; ?></a></li>
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
                        <div class="card">
                            <div class="card-header">

                                <h1 class="mt-4">Export Data Summary</h1>

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
                                                <h5 class="card-title"><b>Data Period</b></h5>
                                            </div>
                                            <div class="card-body">
                                                <form method="post">
                                                    <label for="start_date">Start Date:</label>
                                                    <input type="date" name="start_date" required>

                                                    <label for="end_date">End Date:</label>
                                                    <input type="date" name="end_date" required style="margin-bottom: 20px;"> <!-- Added margin-bottom -->

                                                    <button type="submit" style="background-color: #3498db; color: #fff; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer; width: 100%; display: block;">Export Data</button>
                                                </form>
                                            </div>
                                        </div>


            </body>

            </html>