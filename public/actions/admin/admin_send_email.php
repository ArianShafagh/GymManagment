<?php
ob_start();
session_start();
if (!isset($_SESSION['is_admin'])) { header("Location: ../../pages/admin/login.php"); exit(); }
include '../../../config/db.php';
include '../../../config/mailtrap.php';

$toEmail = $_POST['to_email'];
$subject = $_POST['subject'];
$message = $_POST['message'];

// Get user name
$user_res = $conn->query("SELECT first_name FROM users WHERE email='" . $conn->real_escape_string($toEmail) . "'");
$toName = $user_res->num_rows > 0 ? $user_res->fetch_assoc()['first_name'] : 'Member';

try {
    sendMail($toEmail, $toName, $subject, $message);
    error_log("Admin email sent to $toEmail");
} catch (\Throwable $e) {
    error_log("Admin email failed: " . $e->getMessage());
}

header("Location: ../../pages/admin/dashboard.php");
exit();
?>
