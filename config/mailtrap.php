<?php

require __DIR__ . '/../vendor/autoload.php';

use Mailtrap\MailtrapClient;
use Mailtrap\Mime\MailtrapEmail;
use Symfony\Component\Mime\Address;

/**
 * Send an OTP email to the user via Mailtrap SDK (sandbox mode).
 * Called from Login.php and Verify2FA.php when the user has email 2FA enabled.
 */
function sendOTPEmail($toEmail, $toName, $otpCode) {
    try {
        // 4. Initialize client (sandbox mode for testing)
            $mailtrap = MailtrapClient::initSendingEmails(
            apiKey: getenv('MailTrap_api_key')
        );

        // 5. Build the email
        $email = (new MailtrapEmail())
            ->from(new Address('hello@ariangym.app', 'Bull Gym Security'))
            ->to(new Address($toEmail, $toName))
            ->subject('Your Bull Gym Verification Code')
            ->text("Your verification code is: $otpCode\n\nThis code expires in 5 minutes.\nIf you did not request this, please ignore this email.")
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

function sendMail($toEmail, $toName, $subject, $message) {
    try {
        $mailtrap = MailtrapClient::initSendingEmails(
        apiKey: getenv('MailTrap_api_key'),
        );

        $email = (new MailtrapEmail())
            ->from(new Address('hello@ariangym.app', 'Bull Gym Admin'))
            ->to(new Address($toEmail, $toName))
            ->subject($subject)
            ->text($message)
            ->category('Admin Email');

        $response = $mailtrap->send($email);

        error_log("=== MAILTRAP: Email sent successfully to $toEmail ===");
        return true;

    } catch (\Throwable $e) {
        error_log("=== MAILTRAP: EMAIL FAILED ===");
        error_log("Error: " . $e->getMessage());
        error_log("To: $toEmail | Subject: $subject");
        return false;
    }
}