<?php
require_once('connections/mysqli.php');


$Order_ID = "";
$StartDate = "";
$EndDate = "";


$sql_OrderMain = "SELECT * FROM `order_main` where Order_id = '$Order_ID'";
$query_OrderMain = mysqli_query($Connection, $sql_OrderMain);
$result_OrderMain = mysqli_fetch_array($query_OrderMain);

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
            <a class="nav-link" href="shop_inventory.php">Shop inventory</a>
            <a class="nav-link" href="shop_export_data.php">Download</a>
          </div>
        </div>
        <div class="sb-sidenav-footer">
          <div class="small">Logged in as:</div>
          <?php echo $result_shop[3]; ?>
        </div>
      </nav>
    </div>

    <!-- หน้าต่าง Order history -->
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
      <br>

      <body>
        <main>
          <div class="container-fluid px-4">
            <div class="card">
              <div class="card-header">
                <h1 class="mt-4">Order History</h1>
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
                        <br>

                        <!-- General Form Elements -->
                        <form name="Search" method="post" action="">
                          <div class="row mb-3">
                            <label for="inputText" class="col-sm-2 col-form-label">Start Date :</label>
                            <div class="col-sm-6">
                              <input type="date" id="StartDate" name="StartDate" value="<?php echo $StartDate; ?>" placeholder="yyyy-mm-dd" class="form-control">
                            </div>
                          </div>

                          <div class="row mb-3">
                            <label for="inputText" class="col-sm-2 col-form-label">End Date :</label>
                            <div class="col-sm-6">
                              <input type="date" id="EndDate" name="EndDate" value="<?php echo $EndDate; ?>" placeholder="yyyy-mm-dd" class="form-control">
                            </div>

                            <div class="col-sm-2">
                              <button type="submit" class="btn btn-primary" name="Search">Search</button>
                            </div>
                          </div>
                        </form>

                        <!-- Table with stripped rows -->
                        <table class="table table-striped" style="text-align: center">
                          <thead>
                            <tr>
                              <th scope="col" class="narrow-column">Order ID</th>
                              <th scope="col">Date</th>
                              <th scope="col">Status</th>
                              <th scope="col"></th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $StartDate = isset($_POST['StartDate']) ? $_POST['StartDate'] : '';
                            $EndDate = isset($_POST['EndDate']) ? $_POST['EndDate'] : '';

                            if (isset($_POST["Search"]) && $StartDate != '' && $EndDate != '') {
                              // ใช้ prepared statements สำหรับความปลอดภัย
                              $stmt = $Connection->prepare("SELECT * FROM `order_main`  WHERE Order_date >= ? AND Order_date <= ?");
                              $stmt->bind_param("ss", $StartDate, $EndDate);
                              $stmt->execute();
                              $result = $stmt->get_result();

                              if ($result) {
                                while ($row = $result->fetch_assoc()) {
                                  // แสดงผลข้อมูล
                                  echo "<tr>
                    <td>" . htmlspecialchars($row['Order_id']) . "</td>
                    <td class='name'>" . htmlspecialchars($row['Order_date']) . "</td>
                    <td>" . htmlspecialchars($row['Order_status']) . "</td>
                    <td><a href='shop_order_Details.php?orderId=" . htmlspecialchars($row['Order_id']) . "' class='btn btn-primary'>Detail</a></td>
                  </tr>";
                                }
                              }
                              $stmt->close();
                            }
                            ?>

                          </tbody>
                        </table>
                        <br>
                        <!-- End Table with stripped rows -->
                      </div>
        </main>
        <footer class="py-4 bg-light mt-auto">
          <div class="container-fluid px-4">
            <div class="d-flex align-items-center justify-content-between small">
              <div class="text-muted">Copyright &copy; 888Fulfillment 2023</div>

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