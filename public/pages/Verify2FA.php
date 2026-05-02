<?php
ob_start();
session_start();
include '../../config/db.php';
include '../../config/totp.php';
include '../../config/mailtrap.php';

// Must have pending 2FA
if (!isset($_SESSION['2fa_user_id'])) {
    header("Location: Login.php");
    exit();
}

$user_id = $_SESSION['2fa_user_id'];
$method = $_SESSION['2fa_method'];

$user_res = $conn->query("SELECT * FROM users WHERE id='$user_id'");
$user = $user_res->fetch_assoc();

$error = '';
$success = '';

// Handle resend for email method
if (isset($_GET['resend']) && $method === 'email') {
    $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    $expires = date('Y-m-d H:i:s', time() + 600); // 10 minutes
    $conn->query("UPDATE users SET email_otp='$otp', email_otp_expires='$expires' WHERE id='$user_id'");
    sendOTPEmail($user['email'], $user['first_name'], $otp);
    $success = "A new code has been sent to your email.";
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = trim($_POST['code'] ?? '');

    if ($method === 'email') {
        // Verify email OTP
        $res = $conn->query("SELECT email_otp, email_otp_expires FROM users WHERE id='$user_id'");
        $row = $res->fetch_assoc();

        // DEBUG: Log the comparison values
        $debugLog = __DIR__ . '/../../mailtrap_debug.log';
        $timestamp = date('Y-m-d H:i:s');
        file_put_contents($debugLog, "[$timestamp] VERIFY ATTEMPT\n", FILE_APPEND);
        file_put_contents($debugLog, "Submitted code: '$code' (type: " . gettype($code) . ", len: " . strlen($code) . ")\n", FILE_APPEND);
        file_put_contents($debugLog, "Stored OTP:     '{$row['email_otp']}' (type: " . gettype($row['email_otp']) . ", len: " . strlen($row['email_otp']) . ")\n", FILE_APPEND);
        file_put_contents($debugLog, "Match: " . ($row['email_otp'] === $code ? 'YES' : 'NO') . "\n", FILE_APPEND);
        file_put_contents($debugLog, "OTP expires at: {$row['email_otp_expires']}\n", FILE_APPEND);
        file_put_contents($debugLog, "Expiry timestamp: " . strtotime($row['email_otp_expires']) . "\n", FILE_APPEND);
        file_put_contents($debugLog, "Current time():   " . time() . "\n", FILE_APPEND);
        file_put_contents($debugLog, "Expired: " . (strtotime($row['email_otp_expires']) > time() ? 'NO (still valid)' : 'YES (expired)') . "\n\n", FILE_APPEND);

        if ($row['email_otp'] === $code && strtotime($row['email_otp_expires']) > time()) {
            // Clear the OTP
            $conn->query("UPDATE users SET email_otp=NULL, email_otp_expires=NULL WHERE id='$user_id'");
            
            // Complete login
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_name'] = $user['first_name'];
            unset($_SESSION['2fa_user_id']);
            unset($_SESSION['2fa_method']);
            
            // Log login
            $ip = $_SERVER['REMOTE_ADDR'];
            $device = $_SERVER['HTTP_USER_AGENT'];
            $conn->query("INSERT INTO login_history (user_id, ip_address, device_info) VALUES ('$user_id', '$ip', '$device')");
            
            header("Location: Account.php");
            exit();
        } else {
            $error = "Invalid or expired code. Please try again.";
        }

    } elseif ($method === 'google_auth') {
        // Verify TOTP
        if (TOTP::verifyCode($user['totp_secret'], $code)) {
            // Complete login
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_name'] = $user['first_name'];
            unset($_SESSION['2fa_user_id']);
            unset($_SESSION['2fa_method']);
            
            // Log login
            $ip = $_SERVER['REMOTE_ADDR'];
            $device = $_SERVER['HTTP_USER_AGENT'];
            $conn->query("INSERT INTO login_history (user_id, ip_address, device_info) VALUES ('$user_id', '$ip', '$device')");
            
            header("Location: Account.php");
            exit();
        } else {
            $error = "Invalid code. Please check your authenticator app.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Two-Step Verification - Bull Gym</title>
    <link rel="title icon" href="../assets/download.png">
    <link rel="stylesheet" href="../bootstrap/bootstrap.min.css">
    <link href='https://cdn.boxicons.com/3.0.6/fonts/basic/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=BBH+Bartle&display=swap" rel="stylesheet">
    <style>
        .verify-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            max-width: 450px;
            padding: 40px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.3);
        }
        .code-input {
            font-size: 28px;
            letter-spacing: 12px;
            text-align: center;
            font-weight: bold;
            padding: 15px;
            border: 2px solid #dc3545;
            border-radius: 10px;
        }
        .code-input:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        }
    </style>
</head>
<body>
    <div class="min-vh-100 d-flex flex-column align-items-center justify-content-center" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d0a0a 100%);">
        
        <a href="Home.php">
            <img src="../assets/download.png" alt="Logo" style="width: 100px; height: 100px;" class="mb-4">
        </a>

        <div class="verify-card text-center">
            <?php if ($method === 'email'): ?>
                <i class='bx bx-envelope' style="font-size: 50px; color: #dc3545;"></i>
                <h2 class="anton-regular mt-3">Email Verification</h2>
                <p class="text-muted">We sent a 6-digit code to<br><strong><?php echo htmlspecialchars($user['email']); ?></strong></p>
            <?php else: ?>
                <i class='bx bx-shield-quarter' style="font-size: 50px; color: #dc3545;"></i>
                <h2 class="anton-regular mt-3">Authenticator Code</h2>
                <p class="text-muted">Enter the 6-digit code from your<br><strong>Google Authenticator</strong> app</p>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="alert alert-danger py-2"><?php echo $error; ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="alert alert-success py-2"><?php echo $success; ?></div>
            <?php endif; ?>

            <form method="POST" class="mt-3">
                <input type="text" name="code" class="form-control code-input mb-4" 
                       maxlength="6" placeholder="000000" required autofocus
                       pattern="[0-9]{6}" inputmode="numeric">
                <button type="submit" class="btn btn-danger w-100 py-2 fs-5">Verify</button>
            </form>

            <?php if ($method === 'email'): ?>
                <p class="mt-3 mb-0">
                    <a href="Verify2FA.php?resend=1" class="text-danger">Resend Code</a>
                </p>
            <?php endif; ?>

            <hr>
            <a href="Login.php" class="text-muted text-decoration-none">
                <i class='bx bx-arrow-back'></i> Back to Login
            </a>
        </div>
    </div>

    <script src="../bootstrap/jquery-3.6.0.min.js"></script>
    <script src="../bootstrap/bootstrap.min.js"></script>
</body>
</html>
