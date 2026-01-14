<?php
session_start();
include 'phak_math.php';

if (!isset($_SESSION['UserID'])) {
    header("Location: Login.html");
    exit();
}

$userid = $_SESSION['UserID'];
$sql = "SELECT * FROM user WHERE UserID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $userid);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_userid = trim($_POST['UserID']);
    $Title = $_POST['Title'];
    $Fname = $_POST['First_name'];
    $Lname = $_POST['Last_name'];
    $Email = $_POST['Email'];
    $Gender = $_POST['Gender'];
    $Aca = $_POST['Academic_pos'];
    $Adm = $_POST['Administrative_pos'];
    $Dep = $_POST['Department'];
    $Emp = $_POST['Emp_type'];

    // ตรวจสอบว่า UserID ซ้ำหรือไม่
    $check_sql = "SELECT UserID FROM user WHERE UserID = ? AND UserID != ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ss", $new_userid, $userid);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        echo "<script>alert('ชื่อบัญชีนี้ถูกใช้งานแล้ว กรุณาเลือกชื่อบัญชีอื่น'); window.location.href='Edit_profile.php';</script>";
        exit();
    }

    $check_stmt->close();

    // อัปเดตข้อมูลในฐานข้อมูล
    $update_sql = "UPDATE user SET UserID = ?, Title = ?, First_name = ?, Last_name = ?, Email = ?, Gender = ?, Academic_pos = ?, Administrative_pos = ?, Department = ?, Emp_type = ? WHERE UserID = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("sssssssssss", $new_userid, $Title, $Fname, $Lname, $Email, $Gender, $Aca, $Adm, $Dep, $Emp, $userid);

    if ($update_stmt->execute()) {
        $_SESSION['UserID'] = $new_userid; // อัปเดต UserID ใน session
        header("Location: Profile.php");
        exit();
    } else {
        echo "เกิดข้อผิดพลาดในการอัปเดตข้อมูล: " . $update_stmt->error;
    }

    $update_stmt->close();
}
$conn->close();
?>



<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขข้อมูลส่วนตัว</title>
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

        .re-box {
            width: 100%;
            max-width: 50%;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
            animation: loginFadeIn 0.5s ease;
            padding-top: 30px;
            border: 3px groove #000000;
            margin-bottom: 30px;
        }

        /* ทำให้เนื้อหาขยับลงมาให้ไม่ทับกับแถบเมนู */
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

        .content {
            margin-top: 3%;
            text-align: center;
            color: #ffffff;
            font-size: 30px;
            text-shadow: black 0px 0px 3px;
        }
        /* ปรับขนาด radio button */
        input[type="radio"] {
            appearance: none;
            /* ซ่อนดีไซน์ดั้งเดิม */
            width: 18px;
            height: 18px;
            border: 2px solid #007bff;
            border-radius: 50%;
            display: inline-block;
            position: relative;
            cursor: pointer;
            background-color: white;
            vertical-align: middle;
        }

        /* เมื่อเลือกให้มีจุดวงกลมด้านใน */
        input[type="radio"]:checked {
            background-color: #007bff;
            border-color: #0056b3;
        }

        input[type="radio"]::before {
            content: "";
            width: 10px;
            height: 10px;
            background-color: white;
            border-radius: 50%;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0);
            transition: 0.2s ease-in-out;
        }

        /* แสดงจุดเมื่อเลือก */
        input[type="radio"]:checked::before {
            transform: translate(-50%, -50%) scale(1);
        }

        /* ปรับระยะห่างให้สวย */
        label {
            margin-right: 15px;
            font-size: 16px;
            cursor: pointer;
        }

        select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 2px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            background-color: white;
            cursor: pointer;
            transition: 0.3s;
            font-family: 'Noto Sans Thai', sans-serif;
        }

        select:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .back-icon img {
            width: 40px;
            height: 40px;
            margin-left: 20px;

        }

        .register-header {
            position: fixed;
            top: 0;
            width: 100%;
            background: linear-gradient(135deg, #1a1461, #3b2e8a);
            padding: 15px 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .register-back-btn {
            color: white;
            font-size: 20px;
            text-decoration: none;
            position: absolute;
            left: 20px;
            transition: color 0.3s ease;
        }

        .register-back-btn:hover {
            color: #ddd;
        }

        .register-title {
            color: white;
            font-size: 24px;
            font-weight: 600;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .register-main {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 80px 20px 20px;
        }

        .register-box {
            width: 100%;
            max-width: 800px;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            animation: registerFadeIn 0.5s ease;
        }

        .register-form-new {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .register-section {
            background: #f3f2f2;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 10px;
        }

        .register-section-title {
            color: #000000;
            font-size: 18px;
            font-weight: 600;
            margin: 0 0 15px;
        }

        .register-row {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .register-input-group {
            flex: 1 1 45%;
            min-width: 300px;
        }

        .register-label {
            font-size: 14px;
            font-weight: 500;
            color: #1a1461;
            margin-bottom: 8px;
            display: block;
            text-align: left;
        }

        .register-note {
            font-size: 12px;
            color: #ff4d4d;
            font-style: italic;
        }

        .register-input,
        .register-select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            background-color: #f5f5f5;
            box-sizing: border-box;
            transition: all 0.3s ease;
            font-family: 'Noto Sans Thai', sans-serif;
        }

        .register-input:focus,
        .register-select:focus {
            border-color: #1a1461;
            box-shadow: 0 0 8px rgba(26, 20, 97, 0.2);
            outline: none;
        }

        .register-checkbox-group {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }

        .register-checkbox-group label {
            display: flex;
            align-items: center;
            gap: px;
            font-size: 14px;
            color: #333;

        }

        .register-submit-btn {
            background: linear-gradient(90deg, #f57c00, #ff9800);
            color: white;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-top: 10px;
            width: 30%;
            font-family: 'Noto Sans Thai', sans-serif;
        }

        .register-submit-btn:hover {
            background: linear-gradient(90deg, #ff9800, #f57c00);
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 10);
        }

        .register-alert {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            font-size: 14px;
        }

        .register-alert-success {
            background: #d4edda;
            color: #155724;
        }

        .register-alert-danger {
            background: #f8d7da;
            color: #721c24;
        }

        @keyframes registerFadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .register-box {
                padding: 20px;
            }

            .register-input-group {
                flex: 1 1 100%;
                min-width: 100%;
            }

            .register-row {
                flex-direction: column;
                gap: 15px;
            }
        }
            
    </style>
</head>

<body>

    <div class="top-bar">

        <a href="Profile.php">
         <span class="back-icon">
                <img src="img/angle-left.png">
            </span>
        </a>
    </div>

    
<div class="content">
            <h1>แก้ไขข้อมูลส่วนตัว</h1>
        </div>

        <div class="re-box">
        <div class="form-container">
            <form action="" method="post" >
                <div class="register-section">
                    <h3 class="register-section-title">ข้อมูลบัญชี</h3>
                    <div class="register-row">
                        <div class="register-input-group">
                            <label class="register-label" for="UserID">ชื่อบัญชีผู้ใช้</label>
                            <input class="register-input" type="text" name="UserID" value="<?php echo htmlspecialchars($user['UserID']); ?>" required>
                        </div>
                    </div>
                </div>
                <div class="register-section">
                    <h3 class="register-section-title">ข้อมูลส่วนตัว</h3>
                    <div class="register-row">

                        <div class="register-input-group">
                            <label class="register-label" for="Title">คำนำหน้า</label>
                            <select class="register-select" name="Title" required>
                            <option value="" disabled selected>เลือกคำนำหน้า</option>
                    <option value="นาย"<?php echo ($user['Title'] == 'นาย') ? 'selected' : ''; ?>>นาย</option>
                    <option value="นางสาว"<?php echo ($user['Title'] == 'นางสาว') ? 'selected' : ''; ?>>นางสาว</option>
                    <option value="นาง"<?php echo ($user['Title'] == 'นาง') ? 'selected' : ''; ?>>นาง</option>
                            </select>
                        </div>
                        <div class="register-input-group">
                            <label class="register-label" for="Gender">เพศ</label>
                            <div class="register-checkbox-group">

                            <input type="radio" id="male" name="Gender" value="ชาย" <?php echo ($user['Gender'] == 'ชาย') ? 'checked' : ''; ?>>ชาย
                            <input type="radio" id="female" name="Gender" value="หญิง" <?php echo ($user['Gender'] == 'หญิง') ? 'checked' : ''; ?>>หญิง
                            </div>
                        </div>
                        <div class="register-input-group">
                            <label class="register-label for=" First_name">ชื่อ</label>
                            <input class="register-input" type="text" name="First_name" value="<?php echo htmlspecialchars($user['First_name']); ?>" required>
                        </div>
                        <div class="register-input-group">
                            <label class="register-label for=" Last_name">นามสกุล</label>
                            <input class="register-input" type="text" name="Last_name" value="<?php echo htmlspecialchars($user['Last_name']); ?>" required>
                        </div>
                    </div><br>
                    <div class="register-row">
                        <div class="register-input-group">
                            <label class="register-label for=" Email">Email</label>
                            <input class="register-input" type="email" name="Email" value="<?php echo htmlspecialchars($user['Email']); ?>" required>
                        </div>
                    </div>
                </div>
                <div class="register-section">
                    <h3 class="register-section-title">ข้อมูลวิชาการและบริหาร</h3>
                    <div class="register-row">
                        <div class="register-input-group">
                            <label class="register-label" for="Academic_pos">ตำแหน่งทางวิชาการ</label>
                            <select name="Academic_pos" class="register-select" required>
                            <option value="-">-</option> 
                        <option value="ผู้ช่วยศาสตราจารย์" <?php echo ($user['Academic_pos'] == 'ผู้ช่วยศาสตราจารย์') ? 'selected' : ''; ?>>ผู้ช่วยศาสตราจารย์</option>
                        <option value="รองศาสตราจารย์" <?php echo ($user['Academic_pos'] == 'รองศาสตราจารย์') ? 'selected' : ''; ?>>รองศาสตราจารย์</option> 
                        <option value="ศาสตราจารย์" <?php echo ($user['Academic_pos'] == 'ศาสตราจารย์') ? 'selected' : ''; ?>>ศาสตราจารย์</option> 
                            </select>
                        </div>
                        <div class="register-input-group">
                            <label class="register-label" for="Administrative_pos">ตำแหน่งทางบริหาร</label>
                            <select name="Administrative_pos" class="register-select" required>
                            <option value="-">-</option> 
                        <option value="คณบดี" <?php echo ($user['Administrative_pos'] == 'คณบดี') ? 'selected' : ''; ?>>คณบดี</option>
                        <option value="รองคณบดี" <?php echo ($user['Administrative_pos'] == 'รองคณบดี') ? 'selected' : ''; ?>>รองคณบดี</option> 
                        <option value="ผู้ช่วยคณบดี" <?php echo ($user['Administrative_pos'] == 'ผู้ช่วยคณบดี') ? 'selected' : ''; ?>>ผู้ช่วยคณบดี</option>
                        <option value="ผู้อำนวยการศูนย์" <?php echo ($user['Administrative_pos'] == 'ผู้อำนวยการศูนย์') ? 'selected' : ''; ?>>ผู้อำนวยการศูนย์</option>
                        <option value="หัวหน้าภาควิชา" <?php echo ($user['Administrative_pos'] == 'หัวหน้าภาควิชา') ? 'selected' : ''; ?>>หัวหน้าภาควิชา</option>
                            </select>
                        </div>
                    </div><br>
                    <div class="register-row">
                        <div class="register-input-group">
                            <label class="register-label" for="Department">ภาควิชา</label>
                            <select name="Department" class="register-select" required>
                            <option value="" disabled>เลือกภาควิชา</option> 
                        <option value="คณิตศาสตร์" <?php echo ($user['Department'] == 'คณิตศาสตร์') ? 'selected' : ''; ?>>คณิตศาสตร์</option>
                        <option value="ฟิสิกส์" <?php echo ($user['Department'] == 'ฟิสิกส์') ? 'selected' : ''; ?>>ฟิสิกส์</option> 
                        <option value="เคมี" <?php echo ($user['Department'] == 'เคมี') ? 'selected' : ''; ?>>เคมี</option> 
                        <option value="ชีววิทยา" <?php echo ($user['Department'] == 'ชีววิทยา') ? 'selected' : ''; ?>>ชีววิทยา</option>
                        <option value="วิทยาการคอมพิวเตอร์" <?php echo ($user['Department'] == 'วิทยาการคอมพิวเตอร์') ? 'selected' : ''; ?>>วิทยาการคอมพิวเตอร์</option> 
                        <option value="สถิติ" <?php echo ($user['Department'] == 'สถิติ') ? 'selected' : ''; ?>>สถิติ</option> 
                        <option value="ศูนย์เครื่องมือวิทยาศาสตร์" <?php echo ($user['Department'] == 'ศูนย์เครื่องมือวิทยาศาสตร์') ? 'selected' : ''; ?>>ศูนย์เครื่องมือวิทยาศาสตร์</option>
                        <option value="K-DAI" <?php echo ($user['Department'] == 'K-DAI') ? 'selected' : ''; ?>>K-DAI</option> 
                            </select>
                        </div>
                        <div class="register-input-group">
                            <label class="register-label" for="Emp_type">ประเภทพนักงาน</label>
                            <div class="register-checkbox-group">
                            <input type="radio" id="emp1" name="Emp_type" value="ข้าราชการ" <?php echo ($user['Emp_type'] == 'ข้าราชการ') ? 'checked' : ''; ?>>
                    <label for="emp1">ข้าราชการ</label>

                    <input type="radio" id="emp2" name="Emp_type" value="พนักงาน" <?php echo ($user['Emp_type'] == 'พนักงาน') ? 'checked' : ''; ?>>
                    <label for="emp2">พนักงาน</label>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <input class="register-submit-btn" type="submit" value="บันทึก">
        </form>
    </div>

</body>
</html>