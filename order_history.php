<?php
session_start();

// Username is root
//$user = 'root';
//$password = '';
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fulfillment_db";

// Server is localhost with
// port number 3306
//$servername='localhost:3306';
$conn = new mysqli(
  $servername,
  $username,
  $password,
  $dbname
);

// Checking for connections
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $orderID = $_POST['Order_ID'];
  $startDate = $_POST['Order_Date'];
  $endDate = $_POST['Order_Date'];

  // SQL query to fetch orders based on order ID and date range
  $sql = "SELECT * FROM order WHERE Order_Date BETWEEN $startDate AND $endDate";
  $resultorder = $conn->query($sql);
}
//$sqlorder = "SELECT * FROM order WHERE Order_ID = (SELECT Order_Id FROM fulfillment_db WHERE Tel LIKE '$strKeyword' LIMIT 1)";
//$queryorder = $mysqli->query($sqlorder);

?>

<!DOCTYPE html>
<html lang="en">
<main id="main" class="main">

  <body>
    <div class="pagetitle">
      <br>
      <h1>Order History</h1>
      <div><?php $resultorder['Order_Date']; ?></div>
      <br>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <br>

              <!-- General Form Elements -->
              <form name="Search" method="post" action="">
                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Order ID</label>
                  <div class="col-sm-8">
                    <input type="text" id="Order_ID" name="Order_ID" placeholder="Input your Order ID" class="form-control" required>
                  </div>

                </div>
                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Start Date : </label>
                  <div class="col-sm-8">
                    <input type="date" id="StartDate" name="StartDate" placeholder="dd-mm-yy" class="form-control" required>
                  </div>

                  <label for="inputText" class="col-sm-2 col-form-label">End Date : </label>
                  <div class="col-sm-8">
                    <input type="date" id="End Date" name="End Date" placeholder="dd-mm-yy" class="form-control" required>

                    <div class="col-sm-2">
                      <button type="submit" class="btn btn-primary" name="Search">Search</button>
                    </div>
                  </div>
              </form>
            </div>

            <!-- Table with stripped rows -->
            <table class="table table-striped" style="text-align: center">
              <thead>
                <tr>
                  <th scope="col">Order ID</th>
                  <th scope="col">Status</th>
                  <th scope="col">Date</th>
                  <th scope="col">Detail</th>
                </tr>
              </thead>
              <tbody>
                <?php
                while($resultorder = mysqli_fetch_array($queryorder,MYSQLI_ASSOC))
                {
                ?>
                  <tr>
                    <th scope="row">1</th>
                    <td><?php echo $resultorder['orderID']; ?></td>
                    <td><?php echo $resultorder['orderID']; ?></td>
                    <td><?php echo $resultorder['orderID']; ?></td>
                    <td><input type="button" class="btn btn-danger" value="Detail" onclick="deleteRow(this)" /></td>
                  </tr>
                  <tr>
                    <th scope="row">2</th>
                    <td><?php echo $resultorder['orderID']; ?></td>
                    <td><?php echo $resultorder['orderID']; ?></td>
                    <td><?php echo $resultorder['orderID']; ?></td>
                    <td><input type="button" class="btn btn-danger" value="Detail" onclick="deleteRow(this)" /></td>
                  </tr>
                  <tr>
                    <th scope="row">3</th>
                    <td><?php echo $resultorder['orderID']; ?></td>
                    <td><?php echo $resultorder['orderID']; ?></td>
                    <td><?php echo $resultorder['orderID']; ?></td>
                    <td><input type="button" class="btn btn-danger" value="Detail" onclick="deleteRow(this)" /></td>
                  </tr>
                <?php
                }
                ?>

              </tbody>
            </table>
            <br>

            <!-- End Table with stripped rows -->