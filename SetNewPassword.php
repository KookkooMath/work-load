<?php
session_start();
include 'phak_math.php';

if (!isset($_SESSION['reset_user'])) {
    echo "<script>alert('ไม่พบข้อมูลผู้ใช้ กรุณาทำรายการใหม่'); window.location.href = 'RequestReset.php';</script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPassword = $_POST['NewPassword'];
    $confirmPassword = $_POST['ConfirmPassword'];

    if ($newPassword !== $confirmPassword) {
        echo "<script>alert('รหัสผ่านไม่ตรงกัน'); window.history.back();</script>";
        exit();
    }

    if (strlen($newPassword) < 8 || !preg_match('/[^\w]/', $newPassword)) {
        echo "<script>alert('รหัสผ่านต้องมีอย่างน้อย 8 ตัว และมีอักขระพิเศษ'); window.history.back();</script>";
        exit();
    }

    $userid = $_SESSION['reset_user'];
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("UPDATE user SET Password = ? WHERE UserID = ?");
    $stmt->bind_param("ss", $hashedPassword, $userid);

    if ($stmt->execute()) {
        unset($_SESSION['reset_user']);
        unset($_SESSION['reset_code']);
        //echo "<script>alert('เปลี่ยนรหัสผ่านสำเร็จ'); window.location.href='Login.html';</script>";
        echo '
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            margin: 0;
            font-family: "Tahoma", sans-serif;
            background: linear-gradient(180deg, #f57c00, #ffffff);
        }
        .modal-overlay {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(255, 255, 255, 0.95);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
        .modal-box {
            background: #fff;
            padding: 30px;
            border-radius: 14px;
            text-align: center;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            max-width: 400px;
            width: 80%;
        }
        .spinner {
            margin: 20px auto;
            width: 50px;
            height: 50px;
            border: 6px solid #e0e0e0;
            border-top: 6px solid #28a745;
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
        p {
            color: #555;
        }
    </style>
    <script>
        setTimeout(function() {
            window.location.href = "Login.html";
        }, 3000);
    </script>
</head>
<body>
    <div class="modal-overlay">
        <div class="modal-box">
            <h2>✅ เปลี่ยนรหัสผ่านสำเร็จ</h2>
            <p>ระบบกำลังนำคุณไปยังหน้าเข้าสู่ระะบบ</p>
            <div class="spinner"></div>
        </div>
    </div>
</body>
</html>';

    } else {
        echo "<script>alert('เกิดข้อผิดพลาดในการเปลี่ยนรหัสผ่าน'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ตั้งรหัสผ่านใหม่</title>
    <link rel="icon" href="img/Logo-phakmath.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@100..900&display=swap" rel="stylesheet">
    <style>
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

        .back-icon img {
            width: 40px;
            height: 40px;
            cursor: pointer;
            margin-left: 20px;
            margin-top: 1px;

        }

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

        .reset-box {
            margin-top: -3%;
            width: 100%;
            max-width: 300px;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
            animation: loginFadeIn 0.5s ease;
            padding-top: 30px;
            border: 3px groove #000000;
            margin-bottom: 5%;
        }

        .content {
            margin-top: 1%;
            text-align: center;
            color: #ffffff;
            font-size: 50px;
            text-shadow: black 0px 0px 3px;
        }

        form {
            display: inline-block;
            margin-top: 5px;
        }

        input[type="password"] {
            padding: 15px;
            margin: 2px ;
            display: block;
            width: 300px;
            box-sizing: border-box;
            font-family: 'Noto Sans Thai', sans-serif;
            border-radius: 18px;
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

        .reset-label {
            font-size: 16px;
            font-weight: 500;
            color:rgb(2, 2, 2);
            margin-bottom: 8px;
            display: block;
            text-align: left;
        }

        input[type="submit"]:hover {
            background-color: #130b5e;
            transform: scale(1.05);
            box-shadow: #000000 0px 0px 10px;
        }

        .button-container {
            display: flex;
            gap: 10px;
            /* ระยะห่างระหว่างปุ่ม */
            justify-content: center;
            /* จัดตรงกลาง */
            align-items: center;
            /* แก้ไขการเลื่อมของปุ่ม */
        }

        .button-container form {
            margin: 0;
            padding: 0;
        }

        .button-container input[type="submit"] {
            margin-top: 10px;
            padding: 10px 20px;
            font-size: 16px;
            width: 150px;
        }
    </style>
</head>

<body>
    <div class="top-bar">
        <a href="VerifyResetCode.php.php">
            <span class="back-icon">
                <img src="img/angle-left.png">
            </span>
        </a>
    </div>
    <div class="reset-box">
        <form action="SetNewPassword.php" method="post">
            <label class="reset-label" for="NewPassword">รหัสผ่านใหม่</label>
            <input type="password" id="NewPassword" name="NewPassword" placeholder="รหัสผ่านใหม่" required><br>
            <label class="reset-label" for="ConfirmPassword">ยืนยันรหัสผ่าน</label>
            <input type="password" id="ConfirmPassword" name="ConfirmPassword" placeholder="ยืนยันรหัสผ่าน"required>
            <div class="button-container">
                <input type="submit" value="บันทึกรหัสผ่านใหม่">
            <div>
        </form>
    </div>

</body>

</html>

