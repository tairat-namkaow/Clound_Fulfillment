<?php
require_once('connections/mysqli.php');

$sql_iadmin = "SELECT * FROM `admin`";
$query_iadmin = mysqli_query($Connection, $sql_iadmin);

// Add error handling
if (!$query_iadmin) {
    die("Error: " . mysqli_error($Connection));
}

// Fetch the admin details
$row = mysqli_fetch_array($query_iadmin);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_info.css">
    <title>Admin Details</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }

        .logo {
            max-width: 200px; /* Adjust the size as needed */
            display: block;
            margin: 0 auto; /* Center the logo */
        }

        .details {
            margin-top: 20px;
            text-align: center; /* Center the content within .details */
        }

        .detail-row {
            display: flex;
            flex-direction: space column; /* Stack label and value vertically */
            align-items: center; /* Center items horizontally */
            margin-bottom: 10px;
        }

        .label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        .value {
            flex-grow: 1;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <img src="user.png" alt="Logo" class="logo">
        <div class="details">
            <div class="detail-row">
                <span class="label">Admin Name:</span>
                <span class="value"><?php echo $row['First_name']; ?></span>
            </div>
            <div class="detail-row">
                <span class="label">Admin ID:</span>
                <span class="value"><?php echo $row['Admin_id']; ?></span>
            </div>
            <div class="detail-row">
                <span class="label">Admin Status:</span>
                <span class="value"><?php echo $row['Order_id']; ?></span>
            </div>
        </div>
    </div>
</body>

</html>
