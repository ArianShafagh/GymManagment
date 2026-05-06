<?php
ob_start();
session_start();

include_once __DIR__ . '/../../../config/admin_guard.php';

$ADMIN_EMAIL = getenv('Admin_email') ?: 'email@example.com';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === getenv('Admin_user') && $password === getenv('Admin_pass')) {
        begin_admin_email_2fa($ADMIN_EMAIL, $username);
        header("Location: ../Verify2FA.php");
        exit();
    } else {
        $error = "Invalid credentials.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Bull Gym</title>
    <link rel="title icon" href="../../assets/download.png">
    <link rel="stylesheet" href="../../bootstrap/bootstrap.min.css">
    <link href='https://cdn.boxicons.com/3.0.6/fonts/basic/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=BBH+Bartle&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../css/admin/login.css">
</head>
<body>
    <div class="admin-login-bg">
        <div class="admin-card text-center">
            <img src="../../assets/download.png" alt="Logo" style="width: 80px; height: 80px;" class="mb-3">
            <h2>ADMIN PANEL</h2>
            <p style="color: #666; font-family: Arial; font-size: 13px;">Authorized personnel only</p>

            <?php if ($error): ?>
                <div class="alert alert-danger py-2" style="font-family: Arial; font-size: 14px;"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST" class="text-start mt-4">
                <div class="mb-3">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" required autofocus>
                </div>
                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-admin w-100 mt-2">LOGIN</button>
            </form>
        </div>
    </div>
    <script src="../../bootstrap/jquery-3.6.0.min.js"></script>
    <script src="../../bootstrap/bootstrap.min.js"></script>
</body>
</html>
