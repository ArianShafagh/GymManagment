<?php
ob_start();
session_start();
if (!isset($_SESSION['is_admin'])) { header("Location: ../../pages/admin/login.php"); exit(); }
include '../../../config/db.php';

$user_id = intval($_POST['user_id']);
 $subscription = $_POST['subscription_type'];
 $duration = intval($_POST['duration_months']);
 $start_date = $_POST['start_date'];
 $end_date = $_POST['end_date'];
 $payment = $_POST['payment_method'];
 $two_fa = $_POST['two_fa_method'];
 $medical = $_POST['medical_notes'] ?? '';
 $health_status = $_POST['health_status'] ?? 'healthy';

 $conn->prepare("UPDATE users SET subscription_type = ?, duration_months = ?, start_date = ?, end_date = ?, payment_method = ?, two_fa_method = ? WHERE id = ?")->execute([$subscription, $duration, $start_date, $end_date, $payment, $two_fa, $user_id]);

 // Update or insert health conditions
 $hstmt = $conn->prepare("SELECT id FROM health_conditions WHERE user_id = ? LIMIT 1");
 $hstmt->execute([$user_id]);
 if ($hstmt->rowCount() > 0) {
     $conn->prepare("UPDATE health_conditions SET medical_notes = ?, health_status = ? WHERE user_id = ?")->execute([$medical, $health_status, $user_id]);
 } else {
     $conn->prepare("INSERT INTO health_conditions (user_id, health_status, medical_notes) VALUES (?,?,?)")->execute([$user_id, $health_status, $medical]);
 }

header("Location: ../../pages/admin/dashboard.php");
exit();
?>
