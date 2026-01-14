<?php
session_start();

if ($_POST['code'] === $_SESSION['reset_code']) {
    header("Location: SetNewPassword.php");
    exit();
} else {
    echo "<script>alert('รหัสไม่ถูกต้อง'); window.history.back();</script>";
}
?>
