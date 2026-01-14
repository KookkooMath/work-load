<?php
include 'phak_math.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $courseID = $_POST['CourseID'];
    $course_name = $_POST['Course_name'];
    $credit_total = $_POST['Credit_total'];
    $credit_lec = $_POST['Credit_lecture'];
    $credit_lab = $_POST['Credit_lab'];
    $credit_independent = $_POST['Credit_independent'];

    // ตรวจสอบว่ามี CourseID นี้อยู่แล้วหรือไม่
    $check_sql = "SELECT COUNT(*) FROM courses WHERE CourseID = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $courseID);
    $check_stmt->execute();
    $check_stmt->bind_result($count);
    $check_stmt->fetch();
    $check_stmt->close();

    if ($count > 0) {
        // ถ้ามี CourseID ซ้ำอยู่แล้ว
        echo "<script>alert('มีรหัสวิชานี้ในระบบแล้ว!'); window.history.back();</script>";
    } else {
        // ถ้าไม่มี ให้เพิ่มข้อมูล
        $sql = "INSERT INTO courses (CourseID, Course_name, Credit_total, Credit_lecture, Credit_lab, Credit_independent) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssiiii", $courseID, $course_name, $credit_total, $credit_lec, $credit_lab, $credit_independent);

        if ($stmt->execute()) {
            echo "<script>alert('เพิ่มวิชาสำเร็จ!'); window.location.href='TeachingInformation.php';</script>";
        } else {
            echo "<script>alert('เกิดข้อผิดพลาด!');</script>";
        }

        $stmt->close();
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มวิชา</title>
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


        .container {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        input {
            display: block;
            width: calc(100% - 20px);
            padding: 12px;
            margin: 10px auto;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: 0.3s;
            font-family: 'Noto Sans Thai', sans-serif;
        }

        input:focus {
            border-color: #150B6E;
            outline: none;
        }

        .submit-button {
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
            margin: 20px auto;
        }

        .submit-button:hover {
            background-color: #130b5e;
            transform: scale(1.05);
            box-shadow: #000000 0px 0px 10px;
        }

        .menu-icon img {
            width: 40px;
            height: 40px;
            margin-left: 20px;
        }
    </style>
</head>

<body>
    <div class="top-bar">
        <a href="TeachingInformation.php">
            <span class="menu-icon">
                <img src="img/angle-left.png">
            </span>
        </a>
    </div>
    <div class="container">
        <h2>เพิ่มวิชาใหม่</h2>
        <form action="" method="POST">
            <input type="text" name="CourseID" placeholder="รหัสวิชา" required>
            <input type="text" name="Course_name" placeholder="ชื่อวิชา" required>
            <input type="number" name="Credit_total" placeholder="หน่วยกิตรวม" step="1" required>
            <input type="number" name="Credit_lecture" placeholder="หน่วยกิตทฤษฎี" step="1" required>
            <input type="number" name="Credit_lab" placeholder="หน่วยกิตปฏิบัติ" step="1" required>
            <input type="number" name="Credit_independent" placeholder="หน่วยกิตศึกษาด้วยตนเอง" step="1" required>
            <button type="submit" class="submit-button">บันทึกข้อมูล</button>
        </form>
    </div>
</body>

</html>