<?php
session_start();
include 'phak_math.php';  // เชื่อมต่อฐานข้อมูลหรือไฟล์อื่นๆ ที่จำเป็น
require 'vendor/autoload.php';  // โหลด Composer autoload เพื่อใช้งาน PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$userid = trim($_POST['UserID']);  // รับข้อมูลจากฟอร์ม
$Email = trim($_POST['Email']);

// ตรวจสอบในฐานข้อมูลว่ามี user นี้หรือไม่
$sql = "SELECT * FROM user WHERE UserID = ? AND Email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $userid, $Email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // สร้างรหัสสำหรับการรีเซ็ตรหัสผ่าน
    $code = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6);
    $_SESSION['reset_code'] = $code;  // เก็บรหัสใน session
    $_SESSION['reset_user'] = $userid;  // เก็บ userID ใน session

    // ส่งอีเมล
    $mail = new PHPMailer(true);
    try {
        // ตั้งค่า SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  // SMTP ของ Gmail
        $mail->SMTPAuth = true;
        $mail->Username = '64050208@kmitl.ac.th';  // อีเมลของคุณ
        $mail->Password = 'ecbmazcdskvusjjz';  // ใช้ App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // ตั้งค่าผู้ส่งและผู้รับ
        $mail->setFrom('noreply@gmail.com', 'Math Depatment Workload');
        $mail->addAddress($Email);  // ส่งไปที่อีเมลของผู้ใช้

        $mail->Charset = 'UTF-8';  // เพิ่มการตั้งค่า Charset
        $mail->isHTML(true);
        $mail->Subject = mb_encode_mimeheader('รหัสสำหรับรีเซ็ตรหัสผ่าน', 'UTF-8');

        //$mail->Subject = 'Code For Reset Password';
        $mail->Body = "
            <html>
            <head>
                <meta charset='UTF-8'>
                <title>รหัสรีเซ็ตรหัสผ่าน</title>
            </head>
            <body>
                <p>สวัสดีคุณ $userid,</p>
                <p>นี่คือรหัสสำหรับรีเซ็ตรหัสผ่านของคุณ: <b>$code</b></p>
                <p>หากคุณไม่ได้ร้องขอการเปลี่ยนรหัสผ่าน กรุณาเมินเฉยต่ออีเมลนี้</p>
                <br>
                <p>ขอบคุณ,<br>ระบบรีเซ็ตรหัสผ่าน Math Department</p>
            </body>
            </html>";

            
            $mail->addCustomHeader('X-Custom-Header', 'รหัสสำหรับการรีเซ็ตรหัสผ่านของ Math Department');  // เพิ่ม header ตามต้องการ
            //$mail->addReplyTo('support@yourdomain.com', 'Support Team');  // เพิ่ม Reply-To address


        // ส่งอีเมล
        $mail->send();
        echo '
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            margin: 0;
            font-family: "Tahoma", sans-serif;
        }
        .modal-overlay {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: linear-gradient(180deg, #f57c00, #ffffff);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
        .modal-box {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 0 20px rgba(0,0,0,0.15);
            max-width: 400px;
            width: 80%;
        }
        .spinner {
            margin: 20px auto;
            width: 50px;
            height: 50px;
            border: 6px solid #e0e0e0;
            border-top: 6px solid #28a745; /* สีเขียว */
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        h2 {
            color: #28a745;
        }
    </style>
    <script>
        setTimeout(function() {
            window.location.href = "VerifyResetCode.php";
        }, 3000); // เปลี่ยนหน้าใน 3 วินาที
    </script>
</head>
<body>
    <div class="modal-overlay">
        <div class="modal-box">
            <h2>ส่งอีเมลสำเร็จ</h2>
            <p>ระบบได้ส่งรหัสรีเซ็ตรหัสผ่านไปยังอีเมลของคุณแล้ว</p>
            <div class="spinner"></div>
        </div>
    </div>
</body>
</html>';
        //echo "<script>alert('ส่งรหัสไปที่อีเมลแล้ว'); window.location.href='VerifyResetCode.php';</script>";
    } catch (Exception $e) {
        echo "<script>alert('ไม่สามารถส่งอีเมลได้: {$mail->ErrorInfo}'); window.history.back();</script>";
    }
} else {
    // หากไม่พบผู้ใช้หรืออีเมลไม่ตรงกัน
    echo "<script>alert('ไม่พบบัญชีผู้ใช้นี้หรืออีเมลไม่ตรงกัน'); window.history.back();</script>";
}
?>
