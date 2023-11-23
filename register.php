<?php
require_once('connections/mysqli.php');

if ($_SESSION != NULL) {
    header("location:index.php");
    exit();
}

$check_submit = "";
$Shop_name = "";
$Shop_password = "";
$Shop_email = "";
$Shop_address = "";
$Shop_tel = "";

if (isset($_POST["submit"])) {
    $sql = "SELECT * FROM shop WHERE Shop_email = '" . trim($_POST['Shop_email']) . "'";
    $query = mysqli_query($Connection, $sql);
    $result = mysqli_fetch_array($query, MYSQLI_ASSOC);

    $Shop_name = $_POST["Shop_name"];
    $Shop_password = $_POST["Shop_password"];
    $Shop_email = $_POST["Shop_email"];

    if ($result) {
        $check_submit = '<div class="alert alert-danger" role="alert">';
        $check_submit .= '<span><i class="bi bi-info-circle"></i> Email นี้ถูกใช้แล้วกรุณาใช้ Email อื่น</span>';
        $check_submit .= '</div>';
    } else {
        $sql = "INSERT INTO shop (Shop_password,Shop_email,Shop_name,Shop_tel,Shop_address) 
                VALUES ('" . $_POST["Shop_password"] . "','" . $_POST["Shop_email"] . "','" . $_POST["Shop_name"] . "','" . $_POST["Shop_tel"] . "','" . $_POST["Shop_address"] . "')";
        $query = mysqli_query($Connection, $sql);

        header("location:login.php?register=success");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<style>
      .custom-header {
        background-color: #000;
        color: #fff;
        border: none;
      }

      body {
        background-color: #f8f9fa;
      }

      .center-container {
        display: flex;
        justify-content: center;
        min-height: 100vh;
      }
    </style>


<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Register</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="bg-info">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                
                                    <h3 align="center"class="card-header custom-header">Create Account</h3>
                        
                                <div class="card-body">

                                    <form method="post">
                                        <div class="mb-3">
                                            <label class="form-label">Shop name</label>
                                            <input type="text" class="form-control" name="Shop_name" value="<?php echo $Shop_name; ?>" placeholder="Enter Shop name" required />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Shop address</label>
                                            <input type="text" class="form-control" name="Shop_address" value="<?php echo $Shop_address; ?>" placeholder="Enter Shop address" required />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Shop telephone</label>
                                            <input type="text" class="form-control" name="Shop_tel" value="<?php echo $Shop_tel; ?>" placeholder="Enter Shop telephone" required />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="text" class="form-control" name="Shop_email" value="<?php echo $Shop_email; ?>" placeholder="Enter Email" required />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">รหัสผ่าน</label>
                                            <input type="password" class="form-control" name="Shop_password" placeholder="Enter Password" required />
                                        </div>
                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn btn-success" name="submit">สมัครสมาชิก</button>
                                    </form>

                                </div>
                                <div class="text-center mt-3" class="small"><a href="login.php">Have an account? Go to login</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>

</html>