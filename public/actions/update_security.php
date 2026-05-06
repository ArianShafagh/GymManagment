<?php
session_start();
include '../../config/db.php';
if(!isset($_SESSION['user_email'])) {
    header("Location: ../pages/Login.php");
    exit();
}

$email = $_SESSION['user_email'];
$new_password = $_POST['new_password'] ?? '';

 $ustmt = $conn->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
 $ustmt->execute([$email]);
 $user = $ustmt->fetch(PDO::FETCH_ASSOC);
 $user_id = $user['id'];

if(!empty($new_password)) {
    $hashed = password_hash($new_password, PASSWORD_BCRYPT);
    $up = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
    $up->execute([$hashed, $user_id]);
}

header("Location: ../pages/Account.php");
exit();
?>
