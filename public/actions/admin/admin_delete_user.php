<?php
ob_start();
session_start();
if (!isset($_SESSION['is_admin'])) { header("Location: ../../pages/admin/login.php"); exit(); }
include '../../../config/db.php';

$user_id = intval($_GET['id']);

$stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
$stmt->execute([$user_id]);

header("Location: ../../pages/admin/dashboard.php");
exit();
?>
