<?php
header("Content-Type: application/json");
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// เชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "phak_math";
$port = 3307;
$conn = new mysqli($servername, $username, $password, $dbname, $port);
$conn->set_charset("utf8mb4");
if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Connection failed"]));
}


// ตรวจสอบว่ามีค่าที่ส่งมาหรือไม่
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (!isset($_SESSION['UserID'])) {
        echo json_encode(["status" => "error", "message" => "ผู้ใช้ยังไม่ได้เข้าสู่ระบบ"]);
        exit;
    }

    $conn->begin_transaction();

    try {

        $userid = $_SESSION['UserID'];

        // รับค่าจากฟอร์ม
        $courseID = $_POST['CourseID'] ?? '';
        $course_name = $_POST['Course_name'] ?? '';
        $section = $_POST['Section'] ?? '';
        $credit_total = intval($_POST['Credit_total'] ?? 0);
        $credit_lec = intval($_POST['Credit_lecture'] ?? 0);
        $credit_lab = intval($_POST['Credit_lab'] ?? 0);
        $credit_independent = intval($_POST['Credit_independent'] ?? 0);

        $time_start_lec = !empty($_POST['Course_time_start_lecture']) ? $_POST['Course_time_start_lecture'] : NULL;
        $time_end_lec = !empty($_POST['Course_time_end_lecture']) ? $_POST['Course_time_end_lecture'] : NULL;
        $time_start_lab = !empty($_POST['Course_time_start_lab']) ? $_POST['Course_time_start_lab'] : NULL;
        $time_end_lab = !empty($_POST['Course_time_end_lab']) ? $_POST['Course_time_end_lab'] : NULL;


        $course_day = $_POST['Course_day'] ?? '';
        $course_week = isset($_POST['Course_week']) ? count($_POST['Course_week']) : 0;
        $weeks_selected = isset($_POST['Course_week']) ? implode(",", $_POST['Course_week']) : ''; // เก็บสัปดาห์ที่เลือกจริง ๆ
        $std_faculty = $_POST['Student_faculty'] ?? '';
        $std_department = $_POST['Student_department'] ?? '';
        $std_degree = $_POST['Student_degree'] ?? '';
        $std_enroll = $_POST['Student_enroll'] ?? '';
        $std_per_week = $_POST['Student_per_week'] ?? '';
        $year = $_POST['Year'] ?? '';
        $term = $_POST['Term'] ?? '';


        $hpw_bachelor = isset($_POST['Hours_per_week_bachelor_degree']) ? floatval($_POST['Hours_per_week_bachelor_degree']) : NULL;
        $hpw_inter_bachelor = isset($_POST['Hours_per_week_inter_bachelor_degree']) ? floatval($_POST['Hours_per_week_inter_bachelor_degree']) : NULL;
        $hpw_graduate = isset($_POST['Hours_per_week_graduate']) ? floatval($_POST['Hours_per_week_graduate']) : NULL;

        $amount_teach_hpt = $_POST['Amount_teach_hours_per_term'] ?? '';
        $workload_for_reimbursement = isset($_POST['Workload_for_reimbursement']) ? ($_POST['Workload_for_reimbursement']) : NULL;
        $remark = isset($_POST['remark']) ? ($_POST['remark']) : NULL;

        $amount_wpt = $course_week;
        
        // เลือกค่า $hpw ให้ถูกต้องก่อน
        $hpw = $hpw_bachelor ?? $hpw_inter_bachelor ?? $hpw_graduate ?? 0;

        // คำนวณ amount_hpt ตรง ๆ
        $amount_hpt = $hpw * $amount_wpt;

        // คำนวณ amount_teach_hpt ตามเงื่อนไข
        if (!empty($time_start_lab) && !empty($time_end_lab) && $hpw_bachelor !== null) {
            $amount_teach_hpt = $amount_hpt / 2;
        } elseif (!empty($time_start_lec) && !empty($time_end_lec) && $hpw_inter_bachelor !== null) {
            $amount_teach_hpt = $amount_hpt * 2;
        } else {
            $amount_teach_hpt = $amount_hpt ; // fallback default
        }


        /*$hpw = $hpw_bachelor ?? $hpw_inter_bachelor ?? $hpw_graduate ?? 0;
        $amount_hpt = $hpw * $amount_wpt;
        $amount_teach_hpt = $hpw * $amount_wpt;*/


        // บันทึกข้อมูลในตาราง Courses
        /*$stmt1 = $conn->prepare("INSERT INTO Courses (CourseID, Course_name, Credit_total, Credit_lecture, Credit_lab, Credit_independent) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt1->bind_param("ssiiii", $courseID, $course_name, $credit_total, $credit_lec, $credit_lab, $credit_independent);
        if (!$stmt1->execute()) {
            throw new Exception("Error inserting into Courses: " . $stmt1->error);
        }*/

        // บันทึกข้อมูลในตาราง Teach
        $stmt = $conn->prepare("INSERT INTO teach (Section, CourseID, UserID, Course_time_start_lecture, Course_time_end_lecture,
            Course_time_start_lab, Course_time_end_lab, Course_day, Course_week, Weeks_selected, Student_faculty, Student_department, Student_degree,
            Student_enroll, Student_per_week, Year, Term, Hours_per_week_bachelor_degree, Hours_per_week_inter_bachelor_degree,
            Hours_per_week_graduate, Workload_for_reimbursement, remark, Amount_week_per_term, Amount_hours_per_term, Amount_teach_hours_per_term) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE 
            
            Course_time_start_lecture = VALUES(Course_time_start_lecture),
            Course_time_end_lecture = VALUES(Course_time_end_lecture),
            Course_time_start_lab = VALUES(Course_time_start_lab),
            Course_time_end_lab = VALUES(Course_time_end_lab),
            Course_day = VALUES(Course_day),
            Course_week = VALUES(Course_week),
            Weeks_selected = VALUES(Weeks_selected),
            Student_faculty = VALUES(Student_faculty),
            Student_department = VALUES(Student_department),
            Student_degree = VALUES(Student_degree),
            Student_enroll = VALUES(Student_enroll),
            Student_per_week = VALUES(Student_per_week),
            
            
            Hours_per_week_bachelor_degree = VALUES(Hours_per_week_bachelor_degree),
            Hours_per_week_inter_bachelor_degree = VALUES(Hours_per_week_inter_bachelor_degree),
            Hours_per_week_graduate = VALUES(Hours_per_week_graduate),
            Workload_for_reimbursement = VALUES(Workload_for_reimbursement),
            remark = VALUES(remark),
            Amount_week_per_term = VALUES(Amount_week_per_term),
            Amount_hours_per_term = VALUES(Amount_hours_per_term),
            Amount_teach_hours_per_term = VALUES(Amount_teach_hours_per_term)");

        $stmt->bind_param(
            "ssssssssissssiiiidddssidd",
            $section,
            $courseID,
            $userid,
            $time_start_lec,
            $time_end_lec,
            $time_start_lab,
            $time_end_lab,
            $course_day,
            $course_week,
            $weeks_selected,
            $std_faculty,
            $std_department,
            $std_degree,
            $std_enroll,
            $std_per_week,
            $year,
            $term,
            $hpw_bachelor,
            $hpw_inter_bachelor,
            $hpw_graduate,
            $workload_for_reimbursement,
            $remark,
            $amount_wpt,
            $amount_hpt,
            $amount_teach_hpt
        );

        if (!$stmt->execute()) {
            throw new Exception("Error inserting into Teach: " . $stmt->error);
        }

        $conn->commit();

        echo json_encode([
            "status" => "success",
            "message" => "บันทึกข้อมูลเรียบร้อยแล้ว",
            "redirect" => "TeachingInformation.php?Year=$year&Term=$term"
        ]);
        exit;
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
        exit;
    }
}
$conn->close();
