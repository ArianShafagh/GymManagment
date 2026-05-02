<?php
ob_start();
session_start();
if (!isset($_SESSION['is_admin'])) { header("Location: ../../pages/admin/login.php"); exit(); }
include '../../../config/db.php';

$user_id = intval($_POST['user_id']);
$subscription = $conn->real_escape_string($_POST['subscription_type']);
$duration = intval($_POST['duration_months']);
$start_date = $conn->real_escape_string($_POST['start_date']);
$end_date = $conn->real_escape_string($_POST['end_date']);
$payment = $conn->real_escape_string($_POST['payment_method']);
$two_fa = $conn->real_escape_string($_POST['two_fa_method']);
$medical = $conn->real_escape_string($_POST['medical_notes'] ?? '');
$health_status = $conn->real_escape_string($_POST['health_status'] ?? 'healthy');

$conn->query("UPDATE users SET subscription_type='$subscription', duration_months='$duration', start_date='$start_date', end_date='$end_date', payment_method='$payment', two_fa_method='$two_fa' WHERE id='$user_id'");

// Update or insert health conditions
$h = $conn->query("SELECT id FROM health_conditions WHERE user_id='$user_id'");
if ($h->num_rows > 0) {
    $conn->query("UPDATE health_conditions SET medical_notes='$medical', health_status='$health_status' WHERE user_id='$user_id'");
} else {
    $conn->query("INSERT INTO health_conditions (user_id, health_status, medical_notes) VALUES ('$user_id', '$health_status', '$medical')");
}

header("Location: ../../pages/admin/dashboard.php");
exit();
?>
