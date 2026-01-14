<?php
include 'phak_math.php'; // ต้องแน่ใจว่าไฟล์นี้มีการเชื่อมต่อฐานข้อมูล

// ตรวจสอบว่ามีค่าที่ส่งมาหรือไม่
if (isset($_GET['Year'], $_GET['Term'], $_GET['CourseID'], $_GET['Course_day'], $_GET['Section'])) {
    $year = intval($_GET['Year']);
    $term = intval($_GET['Term']);
    $courseID = $conn->real_escape_string($_GET['CourseID']);
    $course_day = $conn->real_escape_string($_GET['Course_day']);
    $section = intval($_GET['Section']);

    // คำสั่ง SQL สำหรับลบข้อมูลจากตาราง teach
    $sql = "DELETE FROM teach WHERE Year = ? AND Term = ? AND CourseID = ? AND Course_day = ? AND Section = ? ";

    // เตรียมคำสั่ง SQL
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iissi", $year, $term, $courseID, $course_day, $section);

    // ลบข้อมูลและแสดงผล
    if ($stmt->execute()) {
        // รีไดเร็กต์ไปหน้าที่ต้องการ
        header("Location: TeachingInformation.php?Year=$year&Term=$term");
        exit(); // หยุดการทำงานทันทีหลัง Redirect
    } else {
        echo "เกิดข้อผิดพลาด: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "ข้อมูลไม่ครบถ้วน";
}

$conn->close();
?>
