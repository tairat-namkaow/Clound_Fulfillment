<?php
  $hostname = "localhost";
  $username = "root";
  $password = "";
  $database = "fulfillment_db";
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

  $title = "fulfillment";

  // เลือกข้อมูลผู้ใช้งาน
  if ($_SESSION != NULL) {
    $sql_Shop = "SELECT * FROM Shop WHERE Shop_Email = '".$_SESSION['Shop_Email']."'";
    $query_Shop = mysqli_query($Connection,$sql_Shop);
    $result_Shop = mysqli_fetch_array($query_Shop);
  }
?>
