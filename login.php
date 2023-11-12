<?php
require_once('connections/mysqli.php');

if ($_SESSION != NULL) {
  header("location:index.php");
  exit();
}

$check_submit = "";
$Shop_email = "";

if (isset($_POST["submit"])) {
  $sql = "SELECT * FROM shop WHERE Shop_email = '" . mysqli_real_escape_string($Connection, $_POST['Shop_email']) . "' and Shop_password = '"
    . mysqli_real_escape_string($Connection, $_POST['Shop_password']) . "'";
  $query = mysqli_query($Connection, $sql);
  $result = mysqli_fetch_array($query, MYSQLI_ASSOC);

  if ($_POST['Shop_email'] == 'Admin1' || $_POST['Shop_email'] == 'Admin2') {
    session_start();
    if ($_POST['Shop_email'] == 'Admin1') {
      $_SESSION['Admin_user'] = 'Admin1';
    }
    if ($_POST['Shop_email'] == 'Admin2') {
      $_SESSION['Admin_user'] = 'Admin2';
    }
    header("location:admin_dashboard.php");
    exit();
  }
  if (!$result) {
    $Shop_email = $_POST['Shop_email'];
    $check_submit = '<div class="alert alert-danger" role="alert">';
    $check_submit .= '<span><i class="bi bi-info-circle"></i> ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง กรุณาตรวจสอบใหม่อีกครั้ง</span>';
    $check_submit .= '</div>';
  } else {
    session_start();
    $_SESSION["Shop_email"] = $result["Shop_email"];
    $_SESSION["Shop_name"] = $result["Shop_name"];

    header("location:index.php");
    exit();
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?php echo $title; ?></title>
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/icons/bootstrap-icons.css">
</head>

<body class="default">
  <?php include 'includes/navbar.php'; ?>
  <div class="container-fluid">
    <div class="col-md-12 mt-4">
      <div class="row justify-content-md-center">
        <div class="col-md-auto"><?php echo $check_submit; ?></div>
      </div>
    </div>
    <div class="row justify-content-md-center">
      <div class="col-md-5 mb-4">
        <div class="card border-dark mt-2">
          <h5 class="card-header">Login System</h5>
          <div class="card-body">
            <div class="row justify-content-md-center mb-2">

            </div>
            <form method="post">
              <div class="mb-3">
                <label class="form-label">ชื่อผู้ใช้</label>
                <input type="text" class="form-control" name="Shop_email" value="<?php echo $Shop_email; ?>" placeholder="Enter Email" required />
              </div>
              <div class="mb-3">
                <label class="form-label">รหัสผ่าน</label>
                <input type="password" class="form-control" name="Shop_password" placeholder="Enter Password" required />
              </div>
              <button type="submit" class="btn btn-success" name="submit">เข้าสู่ระบบ</button>
              <a class="btn btn-warning" href="register.php" role="button">สมัครสมาชิก</a>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <?php mysqli_close($Connection); ?>
</body>

</html>
<?php
if (isset($_GET["register"])) {
  if ($_GET["register"] == "success") {
?>
    <script type="text/javascript">
      alert("สมัครสมาชิกสำเร็จแล้ว เข้าสู่ระบบได้เลย");
    </script>
<?php
  }
}
?>