<?php
  $hostname = "localhost";
  $username = "root";
  $password = "";
  $database = "khidaeng";
  $Connection = mysqli_connect($hostname, $username, $password, $database);

  if (!$Connection) {
    exit('ไม่สามารถเชื่อมต่อกับฐานข้อมูล');
  }

  //ตั้งค่าชุดอักขระไคลเอนต์เริ่มต้น
  mysqli_set_charset($Connection, "utf8");

  //เปิดใช้งาน SESSION
  session_start();

  //ตั้งค่า timezone ในประเทศไทย
  date_default_timezone_set('Asia/Bangkok');

  //กำหนด title เว็บไซต์
  $title = "Khidaeng.com ไข่แดงดอทคอม";

  // เลือกข้อมูลผู้ใช้งาน
  if ($_SESSION != NULL) {
    $sql_tb_user = "SELECT * FROM tb_user WHERE user_username = '".$_SESSION['user_username']."'";
    $query_tb_user = mysqli_query($Connection,$sql_tb_user);
    $result_tb_user = mysqli_fetch_array($query_tb_user);
  }
  
?>
