<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
// เชื่อมต่อฐานข้อมูล
include 'phak_math.php';

// ฟังก์ชันตรวจสอบการเข้าสู่ระบบ
function validateLogin($userid, $pass)
{
    global $conn;
    // ตรวจสอบชื่อผู้ใช้และรหัสผ่านในฐานข้อมูล
    $sql = "SELECT * FROM user WHERE UserID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $userid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // ถ้าพบผู้ใช้ในฐานข้อมูล
        $user = $result->fetch_assoc();
        // ตรวจสอบรหัสผ่าน
        if (password_verify($pass, $user['Password'])) {
            return true; // เข้าสู่ระบบสำเร็จ
        }
    }
    return false; // รหัสผ่านไม่ถูกต้อง
}

// ตรวจสอบว่ามีการตั้งค่า session สำหรับจำนวนครั้งที่ผิดหรือไม่
if (!isset($_SESSION['attempt_count'])) {
    $_SESSION['attempt_count'] = 0;
}

if (isset($_POST['UserID']) && isset($_POST['Password'])) {
    $userid = $_POST['UserID'];
    $pass = $_POST['Password'];

    // ตรวจสอบการเข้าสู่ระบบ
    if (validateLogin($userid, $pass)) {
        $_SESSION['UserID'] = $userid;  // บันทึก UserID ลงใน Session
        $_SESSION['attempt_count'] = 0;  // รีเซ็ตจำนวนครั้งที่ผิด
        echo "<script>
                window.location.href = 'TeachingInformation.php'; 
              </script>";
    } else {
        // เพิ่มจำนวนการกรอกผิด
        $_SESSION['attempt_count']++;

        // ถ้าผิด 3 ครั้งขึ้นไป
        if ($_SESSION['attempt_count'] >= 3) {
            // ให้ผู้ใช้เปลี่ยนรหัสผ่าน
            echo "<script>
                    alert('คุณกรอกรหัสผ่านผิด 3 ครั้ง กรุณาเปลี่ยนรหัสผ่าน');
                    window.location.href = 'RequestReset.php'; // ไปยังหน้าการเปลี่ยนรหัสผ่าน
                  </script>";
            // รีเซ็ตจำนวนครั้งที่ผิด
            $_SESSION['attempt_count'] = 0;
        } else {
            // แจ้งให้ทราบว่ากรอกผิด
            echo "<script>
                    alert('ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง');
                    window.location.href = 'Login.html'; // กลับไปหน้า login
                  </script>";
        }
    }
}
