<?php
session_start();
session_unset(); // ลบตัวแปร session ทั้งหมด
session_destroy(); // ทำลาย session
header("Location: Login.html"); // เปลี่ยนเส้นทางไปหน้า login
exit();
?>
