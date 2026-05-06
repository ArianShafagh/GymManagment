<?php
session_start();
include '../../config/db.php';
include '../../config/totp.php';

if (!isset($_SESSION['user_email'])) {
    header("Location: ../pages/Login.php");
    exit();
}

$email = $_SESSION['user_email'];
 $ustmt = $conn->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
 $ustmt->execute([$email]);
 $user = $ustmt->fetch(PDO::FETCH_ASSOC);
 $user_id = $user['id'];

$method = $_POST['two_fa_method'] ?? 'none';

if ($method === 'none') {
    // Disable 2FA
    $u = $conn->prepare("UPDATE users SET two_fa_method = 'none', totp_secret = NULL, email_otp = NULL, email_otp_expires = NULL WHERE id = ?");
    $u->execute([$user_id]);
} elseif ($method === 'email') {
    // Enable email 2FA
    $u = $conn->prepare("UPDATE users SET two_fa_method = 'email', totp_secret = NULL WHERE id = ?");
    $u->execute([$user_id]);
} elseif ($method === 'google_auth') {
    // Generate TOTP secret and enable Google Authenticator
    $secret = TOTP::generateSecret();
    $u = $conn->prepare("UPDATE users SET two_fa_method = 'google_auth', totp_secret = ? WHERE id = ?");
    $u->execute([$secret, $user_id]);
}

header("Location: ../pages/Account.php");
exit();
?>
