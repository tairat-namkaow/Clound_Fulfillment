<?php
require_once('connections/mysqli.php');

$sql_OrderDetail = "SELECT * FROM `detail` 
inner join product on detail.Product_id = product.Product_id
inner join shop on product.Shop_id = shop.Shop_id
WHERE Shop_name = '" . $_SESSION['Shop_name'] . "'";
$query_OrderDetail = mysqli_query($Connection, $sql_OrderDetail);
$result_OrderDetail = mysqli_fetch_array($query_OrderDetail);
?>

<?php
require_once('connections/mysqli.php');

$StartDate = isset($_POST['StartDate']) ? $_POST['StartDate'] : '';
$EndDate = isset($_POST['EndDate']) ? $_POST['EndDate'] : '';
$result = null;

if (isset($_POST["Search"]) && $StartDate != '' && $EndDate != '') {
    $stmt = $Connection->prepare("SELECT * FROM `detail` JOIN order_main ON order_main.Order_id = detail.Order_id WHERE Detail_date >= ? AND Detail_date <= ?");
    $stmt->bind_param("ss", $StartDate, $EndDate);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

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
        /* ... Other styles ... */
    </style>
</head>
<body>
    <main>
        <div class="container-fluid px-4">
            <!-- Table for Order History -->
            <table class="table table-striped" style="text-align: center">
                <!-- ... Table Content ... -->
            </table>

            <!-- Popup for Order Details -->
            <div id="orderDetailsPopup" style="display:none;">
                <!-- Order Details will be loaded here -->
            </div>
        </div>
    </main>

    <script>
    function openOrderDetails(orderId) {
        fetch('Order-Details.php?orderId=' + orderId)
            .then(response => response.text())
            .then(html => {
                document.getElementById("orderDetailsPopup").innerHTML = html;
                document.getElementById("orderDetailsPopup").style.display = "block";
            });
    }

    function closeOrderDetails() {
        document.getElementById("orderDetailsPopup").style.display = "none";
    }
    </script>
</body>
</html>



<!DOCTYPE html>
<html lang="en">




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
                                            <div class="card-body">Order-ID:  <?php echo $result_OrderDetail[2]; ?> </div>
        
   <!-- ลองงง -->                                          
                <select name="Product_id" type="text" required class="form-control">
                    <?php
                    $sql_Order = "SELECT * FROM `Order_main` 
                    inner join detail on Order_main.Order_id = Detail.Order_id
                    where Order_main.Order_id = '" . $_SESSION['Order_id'] . "'";
                    $query_Order = mysqli_query($Connection, $sql_Order);
                    while ($result_Order = mysqli_fetch_array($query_Order)) {
                    ?>
                    <option value="<?= $result_Order['Order_id'] ?>"><?= $result_Order['Order_name'] ?></option>
                    <?php } ?>
                </select>
                                            <div class="card-body">Order-Date:  <?php echo $result_OrderDetail[3]; ?></div>
                                            <div class="card-body">Shop-Name:  <?php echo $result_OrderDetail[15]; ?></div>
                                            <div class="card-body">Address:  <?php echo $result_shop[2]; ?></div>



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



<?php
$sql_ProductID = "SELECT * FROM `detail`
inner join product on detail.Product_id = product.Product_id
inner join shop on product.Shop_id = shop.Shop_id
WHERE Shop_name = '" . mysqli_real_escape_string($Connection, $_SESSION['Shop_name']) . "'";
$query_ProductID = mysqli_query($Connection, $sql_ProductID);

// ดึงข้อมูลทั้งหมดมาเก็บใน array
$products = [];
while ($result_ProductID = mysqli_fetch_assoc($query_ProductID)) {
    $products[] = $result_ProductID;
}
?>

<tr>
    <td class="border-right">
        <?php foreach ($products as $product) { 
            echo htmlspecialchars($product['Product_id']) . "<br>"; 
        }?>
    </td>
    <td class="border-right">
        <?php foreach ($products as $product) { 
            echo htmlspecialchars($product['Product_name']) . "<br>"; 
        }?>
    </td>
    <td>
        <?php foreach ($products as $product) { 
            echo htmlspecialchars($product['Detail_quantity']) . "<br>"; 
        }?>
    </td>
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

                                <!DOCTYPE html>
                                    <html>
                                    <head>
                                        <title>Your Page Title</title>
                                        <style>
                                            body, html {
                                                height: 100%;
                                                margin: 0;
                                                display: flex;
                                                justify-content: center;
                                                align-items: center;
                                                background-color: #f0f0f0; /* สีพื้นหลัง, ปรับตามต้องการ */
                                            }

                                            .center {
                                                display: flex;
                                                justify-content: center;
                                                align-items: center;
                                            }

                                            .btn-link {
                                                text-decoration: none;
                                            }

                                            button {
                                                /* สไตล์ปุ่มตามความต้องการ */
                                            }
                                        </style>
                                    </head>
                                    <body>
                                        <div class="center">
                                            <a href="Order_history2.php" class="btn-link">
                                                <button>OK</button>
                                            </a>
                                        </div>
                                    </body>
                                    </html>
    

                                

                                </body>

                                </html>
                            </div>
















