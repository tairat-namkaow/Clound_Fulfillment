<?php
require_once('connections/mysqli.php');

$sql_order = "SELECT * FROM order_detail inner join shop on order_detail.Shop_ID = shop.Shop_ID
  where shop.Shop_Email = '" . $_SESSION['Shop_Email'] . "' ";
$query_order = mysqli_query($Connection, $sql_order);
#$result_order = mysqli_fetch_array($query_order);
?>

<!DOCTYPE html>
<html lang="en">
<main id="main" class="main">

  <body>
    <div class="pagetitle">
      <br>
      <h1>Order History</h1>
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
                while ($result_order = mysqli_fetch_array($query_order, MYSQLI_ASSOC)) {
                ?>
                  <tr>
                    <th scope="row">1</th>
                    <td><?php echo $result_order['Order_ID']; ?></td>
                    <td><input type="button" class="btn btn-danger" value="Detail" onclick="deleteRow(this)" /></td>
                  </tr>
                  <tr>
                    <th scope="row">2</th>
                    <td><?php echo $result_order['orderID']; ?></td>
                    <td><?php echo $result_order['orderID']; ?></td>
                    <td><?php echo $result_order['orderID']; ?></td>
                    <td><input type="button" class="btn btn-danger" value="Detail" onclick="deleteRow(this)" /></td>
                  </tr>
                  <tr>
                    <th scope="row">3</th>
                    <td><?php echo $result_order['orderID']; ?></td>
                    <td><?php echo $result_order['orderID']; ?></td>
                    <td><?php echo $result_order['orderID']; ?></td>
                    <td><input type="button" class="btn btn-danger" value="Detail" onclick="deleteRow(this)" /></td>
                  </tr>
                <?php
                }
                ?>

              </tbody>
            </table>
            <br>

            <!-- End Table with stripped rows -->