<?php
session_start();
include '../../config/db.php';
include '../../config/totp.php';

if (!isset($_SESSION['user_email'])) {
    header("Location: ../pages/Login.php");
    exit();
}

$email = $_SESSION['user_email'];
$user_res = $conn->query("SELECT id FROM users WHERE email='$email'");
$user = $user_res->fetch_assoc();
$user_id = $user['id'];

$method = $_POST['two_fa_method'] ?? 'none';

if ($method === 'none') {
    // Disable 2FA
    $conn->query("UPDATE users SET two_fa_method='none', totp_secret=NULL, email_otp=NULL, email_otp_expires=NULL WHERE id='$user_id'");
} elseif ($method === 'email') {
    // Enable email 2FA
    $conn->query("UPDATE users SET two_fa_method='email', totp_secret=NULL WHERE id='$user_id'");
} elseif ($method === 'google_auth') {
    // Generate TOTP secret and enable Google Authenticator
    $secret = TOTP::generateSecret();
    $conn->query("UPDATE users SET two_fa_method='google_auth', totp_secret='$secret' WHERE id='$user_id'");
}

header("Location: ../pages/Account.php");
exit();
?>
