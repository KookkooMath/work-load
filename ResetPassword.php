<?php

session_start();
include 'phak_math.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userid = trim($_POST['UserID']);
    $newPassword = $_POST['NewPassword'];
    $confirmPassword = $_POST['ConfirmPassword'];

    if ($newPassword != $confirmPassword) {
        echo "<script>alert('รหัสผ่านใหม่และยืนยันรหัสผ่านไม่ตรงกัน'); window.history.back();</script>";
        exit();
    }

    if (strlen($newPassword) < 8 || !preg_match('/[^\w]/', $newPassword)) {
        echo "<script>alert('รหัสผ่านต้องมีอย่างน้อย 8 ตัวอักษร และมีอักขระพิเศษอย่างน้อย 1 ตัว'); window.history.back();</script>";
        exit();
    }

    $sql = "SELECT * FROM user WHERE UserID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $userid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $sqlUpdate = "UPDATE user SET Password = ? WHERE UserID = ?";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->bind_param("ss", $hashedPassword, $userid);

        if ($stmtUpdate->execute()) {
            echo "<script>alert('เปลี่ยนรหัสผ่านสำเร็จ กรุณาเข้าสู่ระบบ'); window.location.href = 'Login.html';</script>";
            exit();
        } else {
            echo "<script>alert('เกิดข้อผิดพลาด ไม่สามารถเปลี่ยนรหัสผ่านได้'); window.location.href = 'Login.html';</script>";
        }
    } else {
        echo "<script>alert('ไม่พบบัญชีผู้ใช้นี้ในระบบ'); window.location.href = 'Register.html';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เปลี่ยนรหัสผ่าน</title>
    <link rel="icon" href="img/Logo-phakmath.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@100..900&display=swap" rel="stylesheet">
    <style>
        .top-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: linear-gradient(90deg, #f57c00, #ff9800);
            padding: 15px 30px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.3);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease-in-out;
            height: 4%;
        }

        body {
            font-family: 'Noto Sans Thai', sans-serif;
            background: linear-gradient(180deg, #f57c00, #ffffff);
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .form-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            width: 400px;
            text-align: center;
            border: 3px groove #000000;
        }
        .form-container h1 {
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
            text-align: left;
            width: 95%;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            font-size: 18px;
            margin: auto;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        .form-container input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #150b6e;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .form-container input[type="submit"]:hover {
            background-color: #2d209e;
        }
        .back-icon img {
            width: 40px;
            height: 40px;
            margin-left: 20px;
            
        }
        input[type="text"],
        input[type="password"]  {
            font-family: 'Noto Sans Thai', sans-serif;
        }

        input[type="submit"] {
            padding: 15px 25px;
            background: linear-gradient(90deg, #f57c00, #ff9800);
            color: white;
            border: none;
            border-radius: 18px;
            cursor: pointer;
            font-family: 'Noto Sans Thai', sans-serif;
            font-size: 16px;
            font-weight: 600;
            text-transform: uppercase;
            transition: all 0.3s ease;
            background: linear-gradient(90deg, #ff9800, #f57c00);
            width: 130px;
            height: 50px;
        }

        input[type="submit"]:hover {
            background-color: #130b5e;
            transform: scale(1.05);
            box-shadow: #000000 0px 0px 10px;
        }
    </style>
</head>
<body>
    <div class="top-bar">
        <!-- ปุ่มย้อนกลับเป็นสัญลักษณ์ "<" -->
        <a href="Login.html">
    <span class="back-icon">
                <img src="img/angle-left.png">
            </span>
        </a>
    </div>

<div class="form-container">
    <h1>เปลี่ยนรหัสผ่าน</h1>
    <form action="resetpassword.php" method="POST">
        <div class="form-group">
            <label for="UserID">ชื่อบัญชีผู้ใช้</label>
            <input type="text" id="UserID" name="UserID"  required>
        </div>
        <div class="form-group">
            <label for="NewPassword">รหัสผ่านใหม่</label>
            <input type="password" id="NewPassword" name="NewPassword" placeholder="ใส่รหัสผ่านใหม่" required>
        </div>
        <div class="form-group">
            <label for="ConfirmPassword">ยืนยันรหัสผ่าน</label>
            <input type="password" id="ConfirmPassword" name="ConfirmPassword" placeholder="ยืนยันรหัสผ่าน" required>
        </div>
        <input type="submit" value="เปลี่ยนรหัสผ่าน">
    </form>
</div>
</body>
</html>


