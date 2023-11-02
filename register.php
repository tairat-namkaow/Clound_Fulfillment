<?php
require_once('connections/mysqli.php');

if ($_SESSION != NULL) {
    header("location:index.php");
    exit();
}

$check_submit = "";
$Firstname = "";
$Lastname = "";
$Shop_Password = "";
$Shop_Email = "";

if (isset($_POST["submit"])) {
    $sql = "SELECT * FROM shop WHERE Shop_Email = '" . trim($_POST['Shop_Email']) . "'";
    $query = mysqli_query($Connection, $sql);
    $result = mysqli_fetch_array($query, MYSQLI_ASSOC);

    $Firstname = $_POST["Firstname"];
    $Lastname = $_POST["Lastname"];
    $Shop_Password = $_POST["Shop_Password"];
    $Shop_Email = $_POST["Shop_Email"];

    if ($result) {
        $check_submit = '<div class="alert alert-danger" role="alert">';
        $check_submit .= '<span><i class="bi bi-info-circle"></i> Email นี้ถูกใช้แล้วกรุณาใช้ Email อื่น</span>';
        $check_submit .= '</div>';
    } else {
        $sql = "INSERT INTO shop (Firstname,Lastname,Shop_Password,Shop_Email) 
                VALUES ('" . $_POST["Firstname"] . "','" . ($_POST["Lastname"]) . "',
                '" . $_POST["Shop_Password"] . "','" . $_POST["Shop_Email"] . "')";
        $query = mysqli_query($Connection, $sql);

        header("location:login.php?register=success");
        exit();
    }
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
    <title>Register</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Create Account</h3>
                                </div>
                                <div class="card-body">

                                    <form method="post">
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="text" class="form-control" name="Shop_Email" value="<?php echo $Shop_Email; ?>" placeholder="Enter Email" required />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">ชื่อ</label>
                                            <input type="text" class="form-control" name="Firstname" value="<?php echo $Firstname; ?>" placeholder="Enter Name" required />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">นามสกุล</label>
                                            <input type="text" class="form-control" name="Lastname" value="<?php echo $Lastname; ?>" placeholder="Enter lastname" required />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">รหัสผ่าน</label>
                                            <input type="password" class="form-control" name="Shop_Password" placeholder="Enter Password" required />
                                        </div>
                                        <div class="mb-3">
                                        <button type="submit" class="btn btn-success" name="submit">สมัครสมาชิก</button>

                                        </div>
                                        <div class="card-footer text-center py-3">
                                            <div class="small"><a href="login.php">Have an account? Go to login</a></div>
                                        </div>
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
