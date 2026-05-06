<?php
session_start();
include '../../config/db.php';
if(!isset($_SESSION['user_email'])) {
    header("Location: ../pages/Login.php");
    exit();
}

$email = $_SESSION['user_email'];
$first_name = $_POST['first_name'] ?? '';
$last_name = $_POST['last_name'] ?? '';
$medical_notes = trim($_POST['medical_notes'] ?? '');
$health_prob = isset($_POST['health_prob']);

 $ustmt = $conn->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
 $ustmt->execute([$email]);
 $user = $ustmt->fetch(PDO::FETCH_ASSOC);
 $user_id = $user['id'];

 $up = $conn->prepare("UPDATE users SET first_name = ?, last_name = ? WHERE id = ?");
 $up->execute([$first_name, $last_name, $user_id]);

 // Update or insert health conditions
 $health_status = ($health_prob && $medical_notes !== '') ? 'attention' : 'healthy';
 $saved_notes = ($health_status === 'attention') ? $medical_notes : '';

 $hstmt = $conn->prepare("SELECT id FROM health_conditions WHERE user_id = ? LIMIT 1");
 $hstmt->execute([$user_id]);
 if ($hstmt->rowCount() > 0) {
     $conn->prepare("UPDATE health_conditions SET health_status = ?, medical_notes = ? WHERE user_id = ?")->execute([$health_status, $saved_notes, $user_id]);
 } else {
     $conn->prepare("INSERT INTO health_conditions (user_id, health_status, medical_notes) VALUES (?, ?, ?)")->execute([$user_id, $health_status, $saved_notes]);
 }

header("Location: ../pages/Account.php");
exit();
?>
