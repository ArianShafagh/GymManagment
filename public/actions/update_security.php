<?php
session_start();
include '../../config/db.php';
if(!isset($_SESSION['user_email'])) {
    header("Location: ../pages/Login.php");
    exit();
}

$email = $_SESSION['user_email'];
$new_password = $_POST['new_password'] ?? '';
$two_fa_pin = $_POST['two_fa_pin'] ?? NULL;
$enable_2fa = isset($_POST['enable_2fa']) ? 1 : 0;

if(!$enable_2fa) {
    $two_fa_pin = 'NULL'; // to reset
} else {
    $two_fa_pin = "'$two_fa_pin'";
}

$user_res = $conn->query("SELECT id FROM users WHERE email='$email'");
$user = $user_res->fetch_assoc();
$user_id = $user['id'];

if(!empty($new_password)) {
    $hashed = password_hash($new_password, PASSWORD_BCRYPT);
    $conn->query("UPDATE users SET password='$hashed', two_fa_pin=$two_fa_pin WHERE id='$user_id'");
} else {
    $conn->query("UPDATE users SET two_fa_pin=$two_fa_pin WHERE id='$user_id'");
}

header("Location: ../pages/Account.php");
exit();
?>
