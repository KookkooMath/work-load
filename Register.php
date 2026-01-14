<?php
// ตั้งค่าการเชื่อมต่อฐานข้อมูล
include 'phak_math.php';

function validatePassword($pass)
{
    // ต้องมีอักขระพิเศษอย่างน้อย 1 ตัว และความยาวอย่างน้อย 8 ตัว
    $pattern = "/^(?=.*[!@#$%^&*()-_+=])(?=.*[a-zA-Z])(?=.*[0-9]).{8,}$/";

    if (!preg_match($pattern, $pass)) {
        return false; // ไม่ผ่านเงื่อนไข
    }
    return true; // ผ่านเงื่อนไข
}
// รับค่าจากฟอร์ม
$userid = $_POST['UserID'];
$pass = $_POST['Password'];
$Title = $_POST['Title'];
$Fname = $_POST['First_name'];
$Lname = $_POST['Last_name'];
$Gender = $_POST['Gender'];
$Email = $_POST['Email'];
$Aca = $_POST['Academic_pos'];
$Adm = $_POST['Administrative_pos'];
$Dep = $_POST['Department'];
$Emp = $_POST['Emp_type'];


if (validatePassword($pass)) {
    $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);
    echo "รหัสผ่านปลอดภัย";
} else {
    echo "รหัสผ่านต้องมีอักขระพิเศษ และมีความยาวอย่างน้อย 8 ตัว";
}

// ตรวจสอบว่าชื่อผู้ใช้มีอยู่แล้วหรือไม่
$sql_check = "SELECT * FROM user WHERE UserID = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("s", $userid);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    // ถ้ามีผู้ใช้งานนี้อยู่แล้ว
    echo "<script>
                alert('บัญชีนี้มีผู้ใช้งานอยู่แล้ว โปรดลงทะเบียนอีกครั้ง');
                window.location.href = 'Register.html'; // กลับไปหน้าลงทะเบียน
              </script>";
} else {
    // ถ้าไม่มีผู้ใช้นี้ ให้บันทึกข้อมูลลงในฐานข้อมูล
    // ใช้ password_hash เพื่อเข้ารหัสรหัสผ่าน
    //$hashed_password = password_hash($pass, PASSWORD_DEFAULT);

    $sql_insert = "INSERT INTO user (UserID, Password, Title, First_name, Last_name, Gender, Email, Academic_pos, Administrative_pos, Department, Emp_type ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("sssssssssss", $userid, $hashedPassword, $Title, $Fname, $Lname, $Gender, $Email, $Aca, $Adm, $Dep, $Emp);

    if ($stmt_insert->execute()) {
        echo "<script>
                    alert('ลงทะเบียนสำเร็จ');
                    window.location.href = 'Login.html'; // ไปหน้า login
                  </script>";
    } else {
        // เกิดข้อผิดพลาดขณะลงทะเบียน
        echo "<script>
                    alert('เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง');
                    window.location.href = 'Register.html';
                  </script>";
    }

    $stmt_insert->close();
}

// ปิดการเชื่อมต่อฐานข้อมูล
$stmt_check->close();
$conn->close();

