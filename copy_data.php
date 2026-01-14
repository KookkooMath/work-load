<?php
session_start();
include 'phak_math.php';


if (!isset($_SESSION['UserID'])) {
    die("กรุณาเข้าสู่ระบบ");
}

$userid = $_SESSION['UserID'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $copyYear = $_POST['copyYear'];
    $copyTerm = $_POST['copyTerm'];
    $newYear = $_POST['newYear'];
    $newTerm = $_POST['newTerm'];

    // ตรวจสอบว่ามีข้อมูลในปีเก่าหรือไม่
    $check_sql = "SELECT COUNT(*) as count FROM teach WHERE Year = ? AND Term = ? AND UserID = ?";
    $stmt_check = $conn->prepare($check_sql);
    $stmt_check->bind_param("iis", $copyYear, $copyTerm, $userid);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    $row_check = $result_check->fetch_assoc();

    if ($row_check['count'] > 0) {
        // ตรวจสอบว่ามีข้อมูลซ้ำในปีใหม่หรือไม่
        $duplicate_check_sql = "SELECT COUNT(*) as duplicate_count
        FROM teach
        WHERE (CourseID, Section, UserID, Year, Term) IN (
            SELECT CourseID, Section, UserID, ?, ?
            FROM teach
            WHERE Year = ? AND Term = ? AND UserID = ?
        )";

        $stmt_dup = $conn->prepare($duplicate_check_sql);
        $stmt_dup->bind_param("iiiii", $newYear, $newTerm, $copyYear, $copyTerm, $userid);
        $stmt_dup->execute();
        $result_dup = $stmt_dup->get_result();
        $row_dup = $result_dup->fetch_assoc();

        if ($row_dup['duplicate_count'] > 0) {
            echo "<script>alert('มีข้อมูลบางวิชาที่ซ้ำกับปีการศึกษาใหม่ กรุณาตรวจสอบใหม่อีกครั้ง');window.location='TeachingInformation.php';</script>";
            exit();
        }

        // คัดลอกข้อมูลทุกคอลัมน์
        $sql_copy = "INSERT INTO teach (CourseID, UserID, Section, Year, Term, Course_day, 
                                        Course_time_start_lecture, Course_time_end_lecture, 
                                        Course_time_start_lab, Course_time_end_lab, 
                                        Student_faculty, Student_department, Student_degree, 
                                        Student_enroll, Student_per_week, Course_week, Weeks_selected, 
                                        Amount_week_per_term, Hours_per_week_bachelor_degree, 
                                        Hours_per_week_inter_bachelor_degree, Hours_per_week_graduate, 
                                        Amount_hours_per_term, Amount_teach_hours_per_term, 
                                        Workload_for_reimbursement, remark)
                     SELECT CourseID, UserID, Section, ?, ?, Course_day, 
                            Course_time_start_lecture, Course_time_end_lecture, 
                            Course_time_start_lab, Course_time_end_lab, 
                            Student_faculty, Student_department, Student_degree, 
                            Student_enroll, Student_per_week, Course_week, Weeks_selected, 
                            Amount_week_per_term, Hours_per_week_bachelor_degree, 
                            Hours_per_week_inter_bachelor_degree, Hours_per_week_graduate, 
                            Amount_hours_per_term, Amount_teach_hours_per_term, 
                            Workload_for_reimbursement, remark
                     FROM teach 
                     WHERE Year = ? AND Term = ? AND UserID = ?";

        $stmt_copy = $conn->prepare($sql_copy);
        $stmt_copy->bind_param("iiiis", $newYear, $newTerm, $copyYear, $copyTerm, $userid);

        if ($stmt_copy->execute()) {
            echo "<script>alert('คัดลอกข้อมูลเรียบร้อย!'); window.location='TeachingInformation.php';</script>";
        } else {
            echo "<script>alert('เกิดข้อผิดพลาดในการคัดลอกข้อมูล: " . $stmt_copy->error . "');window.location='TeachingInformation.php';</script>";
        }
        $stmt_copy->close();
    } else {
        echo "<script>alert('ไม่มีข้อมูลในปีที่เลือก!');window.location='TeachingInformation.php';</script>";
    }
    $stmt_check->close();
}
