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
                            <span style="color: black;">Shop Information</span>
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
                                <h1 class="mt-4">Order Details</h1>
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
                                            <div class="card-body">Order-ID:<?php echo $result_shop[2]; ?> </div>
                                            <div class="card-body">Order-Date:<?php echo $result_shop[2]; ?></div>
                                            <div class="card-body">Shop-ID:<?php echo $result_shop[2]; ?></div>
                                            <div class="card-body">Address:<?php echo $result_shop[2]; ?></div>



                                            <!DOCTYPE html>

                                            <html lang="th">

                                            <head>
                                                <meta charset="UTF-8">
                                                <title>ตารางสินค้า</title>
                                                <style>
                                                    .border-right {
                                                        border-right: 3px solid black;
                                                    }

                                                    tr td {
                                                        border-bottom: 3px solid black;
                                                    }

                                                    table {
                                                        border-collapse: collapse;
                                                        width: 100%;
                                                    }

                                                    th,
                                                    td {
                                                        padding: 8px;
                                                        text-align: left;
                                                    }
                                                </style>
                                            </head>

                                            <body>

                                                <table>
                                                    <table class="table mx-auto" style="margin-top: 20px; width: auto;">
                                                        <tr>
                                                            <td class="border-right">Product-ID</td>
                                                            <td class="border-right">Product-Name</td>
                                                            <td>Quantity</td>
                                                        </tr>

                                                        <tr>
                                                            <td class="border-right"><?php echo $result_shop[2]; ?></td>
                                                            <td class="border-right"><?php echo $result_shop[2]; ?></td>
                                                            <td><?php echo $result_shop[2]; ?></td>
                                                        </tr>

                                                    </table>

                                            </body>

                                            </html>

                                            </table>
                                        </div>

                                    </body>

                                    </html>
                                </div>
                                <!DOCTYPE html>
                                <html lang="en">

                                <head>
                                    <meta charset="UTF-8">
                                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                    <title>Back Button</title>
                                    <script>
                                        function goBack() {
                                            window.history.back();
                                        }
                                    </script>
                                    <style>
                                        button {
                                            border: 3px solid black;
                                            border-radius: 5px;
                                            padding: 5px 10px;
                                            font-size: 14px;
                                            cursor: pointer;
                                            background-color: white;
                                            transition: background-color 0.3s;
                                            display: inline-block;
                                        }

                                        button:hover {
                                            background-color: #f0f0f0;
                                        }
                                    </style>
                                </head>

                                <body>

                                    <button onclick="goBack()">OK</button>

                                </body>

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