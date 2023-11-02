<?php
require_once('../connections/mysqli.php');

if ($_SESSION == NULL) {
  header("location:../login.php");
  exit();
}

$num = 1;

$sql = "SELECT * FROM tb_user";
$query = mysqli_query($Connection,$sql);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/icons/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/dashboard.css">
    <title>ระบบหลังบ้าน</title>
  </head>
  <body>
    <?php include 'include/header.php'; ?>
    <div class="container-fluid">
      <div class="row">
        <?php include 'include/sidebarMenu.php'; ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">ข้อมูลผู้ใช้งาน</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
              <!-- เพิ่มข้อมูล -->
              <button type="button" class="btn btn-secondary">เพิ่มข้อมูล</button>
            </div>
          </div>
          <table class="table table-bordered table-hover"> <!-- table-sm -->
            <thead>
              <tr class="table-info">
                <th scope="col" width="65px">ลำดับที่</th>
                <th scope="col">ชื่อผู้ใช้</th>
                <th scope="col" width="130px">รหัสผ่าน</th>
                <th scope="col">ขื่อ</th>
                <th scope="col">นามสกุล</th>
                <th scope="col">เพศ</th>
                <th scope="col">อีเมล์</th>
                <th scope="col">ระดับผู้ใช้</th>
                <th scope="col" width="90px">ตัวเลือก</th>
              </tr>
            </thead>
            <tbody>
              <?php
              while ($result = mysqli_fetch_array($query)) {
                ?>
                <tr>
                  <th scope="row"><?php echo $num++; ?></th>
                  <td><?php echo $result[1]; ?></td>
                  <td><button type="button" class="btn btn-warning btn-sm">เปลี่ยนรหัสผ่าน</button></td>
                  <td><?php echo $result[3]; ?></td>
                  <td><?php echo $result[4]; ?></td>
                  <td><?php echo $result[5]; ?></td>
                  <td><?php echo $result[6]; ?></td>
                  <td><?php if ($result[7] == "member") {echo "สมาชิก";}else{echo "ผู้ดูแลระบบ";} ?></td>
                  <td>
                    <!-- ปุ่มแก้ไข -->
                    <button type="button" class="btn btn-success btn-sm"><i class="bi bi-pencil-square"></i></button>
                    <!-- ปุ่มลบ -->
                    <button type="button" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                  </td>
                </tr>
                <?php
              }
              ?>
            </tbody>
          </table>
        </main>
      </div>
    </div>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <?php mysqli_close($Connection); ?>
  </body>
</html>
