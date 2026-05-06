<?php

function begin_admin_email_2fa(string $adminEmail, string $adminName = 'Admin'): void
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    require_once __DIR__ . '/mailtrap.php';

    $otp = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT); #pads means no zero from left, so 123 becomes 000123
    $expires = time() + 600;

    $_SESSION['admin_2fa_pending'] = true;
    $_SESSION['admin_2fa_email'] = $adminEmail;
    $_SESSION['admin_2fa_name'] = $adminName;
    $_SESSION['admin_2fa_code'] = $otp;
    $_SESSION['admin_2fa_expires'] = $expires;

    sendOTPEmail($adminEmail, $adminName, $otp);
}

function is_admin_2fa_pending(): bool
{
    return !empty($_SESSION['admin_2fa_pending']);
}
