<?php
// mailtrap.php - OTP Email Sender for Bull Gym 2FA

// 1. Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 2. Load Composer autoloader
require __DIR__ . '/../vendor/autoload.php';

use Mailtrap\MailtrapClient;
use Mailtrap\Mime\MailtrapEmail;
use Symfony\Component\Mime\Address;

// 3. Load API key
$apiKey = '696572f611268d24458927e38f9ccedd';

/**
 * Send an OTP email to the user via Mailtrap SDK (sandbox mode).
 * Called from Login.php and Verify2FA.php when the user has email 2FA enabled.
 */
function sendOTPEmail($toEmail, $toName, $otpCode) {
    global $apiKey;

    try {
        // 4. Initialize client (sandbox mode for testing)
        $mailtrap = MailtrapClient::initSendingEmails(
            apiKey: $apiKey,
            inboxId: 4589075,  // Your Mailtrap inbox ID
            isSandbox: true,   // true = Email Testing, false = Sending API
        );

        // 5. Build the email
        $email = (new MailtrapEmail())
            ->from(new Address('hello@bullgym.com', 'Bull Gym Security'))
            ->to(new Address($toEmail, $toName))
            ->subject('Your Bull Gym Verification Code')
            ->text("Your verification code is: $otpCode\n\nThis code expires in 5 minutes.\nIf you did not request this, please ignore this email.")
            ->html("
                <div style='font-family: Arial, sans-serif; max-width: 500px; margin: 0 auto; padding: 30px; background: #1a1a1a; color: #fff; border-radius: 10px;'>
                    <h1 style='color: #dc3545; text-align: center;'>BULL GYM</h1>
                    <h2 style='text-align: center;'>Login Verification Code</h2>
                    <div style='background: #333; padding: 20px; border-radius: 8px; text-align: center; margin: 20px 0;'>
                        <span style='font-size: 36px; letter-spacing: 8px; font-weight: bold; color: #dc3545;'>$otpCode</span>
                    </div>
                    <p style='text-align: center; color: #aaa;'>This code expires in <strong>5 minutes</strong>.</p>
                    <p style='text-align: center; color: #666; font-size: 12px;'>If you did not request this code, please ignore this email.</p>
                </div>
            ")
            ->category('2FA Verification');

        // 6. Send
        $response = $mailtrap->send($email);

        // 7. Log success
        error_log("=== MAILTRAP: Email sent successfully to $toEmail | OTP: $otpCode ===");
        error_log("Response: " . print_r(\Mailtrap\Helper\ResponseHelper::toArray($response), true));

        return true;

    } catch (\Throwable $e) {
        // Debug: Log the full error
        error_log("=== MAILTRAP: EMAIL FAILED ===");
        error_log("Error: " . $e->getMessage());
        error_log("To: $toEmail | OTP: $otpCode");

        $debugLog = __DIR__ . '/../mailtrap_debug.log';
        $timestamp = date('Y-m-d H:i:s');
        file_put_contents($debugLog, "[$timestamp] FAILED - {$e->getMessage()} | To: $toEmail | OTP: $otpCode\n", FILE_APPEND);

        return false;
    }
}