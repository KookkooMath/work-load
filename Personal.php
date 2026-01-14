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

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "ไม่มีบัญชีผู้ใช้";
    exit();
}

$conn->close();
