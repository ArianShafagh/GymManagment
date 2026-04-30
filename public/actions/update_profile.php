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
$medical_notes = $_POST['medical_notes'] ?? '';

$user_res = $conn->query("SELECT id FROM users WHERE email='$email'");
$user = $user_res->fetch_assoc();
$user_id = $user['id'];

$conn->query("UPDATE users SET first_name='$first_name', last_name='$last_name' WHERE id='$user_id'");

// Update or insert health conditions
$health_res = $conn->query("SELECT id FROM health_conditions WHERE user_id='$user_id'");
if($health_res->num_rows > 0) {
    $conn->query("UPDATE health_conditions SET medical_notes='$medical_notes' WHERE user_id='$user_id'");
} else {
    $conn->query("INSERT INTO health_conditions (user_id, medical_notes) VALUES ('$user_id', '$medical_notes')");
}

header("Location: ../pages/Account.php");
exit();
?>
