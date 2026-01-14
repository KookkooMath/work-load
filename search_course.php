<?php
include 'phak_math.php';

$response = ["status" => "error", "message" => "Invalid request"];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['CourseID']) && !empty($_POST['CourseID'])) {
        $courseID = trim($_POST['CourseID']);

        // ✅ ใช้ error_log() แทน var_dump() เพื่อดูค่าที่ได้รับแบบไม่กระทบ JSON
        error_log("ค่าที่ได้รับจาก POST: " . $courseID);

        $stmtCourse = $conn->prepare("SELECT Course_name, Credit_total, Credit_lecture, Credit_lab, Credit_independent FROM courses WHERE CourseID = ?");
        if ($stmtCourse) {
            $stmtCourse->bind_param("s", $courseID);
            $stmtCourse->execute();
            $resultCourse = $stmtCourse->get_result();

            if ($resultCourse->num_rows > 0) {
                $courseData = $resultCourse->fetch_assoc();
                $response = ["status" => "success", "course" => $courseData];
            } else {
                $response["message"] = "ไม่พบข้อมูลวิชาในฐานข้อมูล";
            }
            $stmtCourse->close();
        } else {
            $response["message"] = "Database query preparation failed";
        }
    } else {
        $response["message"] = "ไม่มีวิชานี้ในระบบ";
    }
}

// ✅ ให้แน่ใจว่า response เป็น JSON เท่านั้น
header('Content-Type: application/json');
echo json_encode($response);
$conn->close();
?>
