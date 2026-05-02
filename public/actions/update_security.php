<?php
session_start();
include '../../config/db.php';
if(!isset($_SESSION['user_email'])) {
    header("Location: ../pages/Login.php");
    exit();
}

$email = $_SESSION['user_email'];
$new_password = $_POST['new_password'] ?? '';

$user_res = $conn->query("SELECT id FROM users WHERE email='$email'");
$user = $user_res->fetch_assoc();
$user_id = $user['id'];

if(!empty($new_password)) {
    $hashed = password_hash($new_password, PASSWORD_BCRYPT);
    $conn->query("UPDATE users SET password='$hashed' WHERE id='$user_id'");
}

header("Location: ../pages/Account.php");
exit();
?>
