<?php
ob_start();
session_start();
if (!isset($_SESSION['is_admin'])) { header("Location: ../../pages/admin/login.php"); exit(); }
include '../../../config/db.php';
include '../../../config/mailtrap.php';

use Mailtrap\MailtrapClient;
use Mailtrap\Mime\MailtrapEmail;
use Symfony\Component\Mime\Address;

$toEmail = $_POST['to_email'];
$subject = $_POST['subject'];
$message = $_POST['message'];

// Get user name
$user_res = $conn->query("SELECT first_name FROM users WHERE email='" . $conn->real_escape_string($toEmail) . "'");
$toName = $user_res->num_rows > 0 ? $user_res->fetch_assoc()['first_name'] : 'Member';

try {
    $mailtrap = MailtrapClient::initSendingEmails(
        apiKey: $apiKey,
        inboxId: 4589075,
        isSandbox: true,
    );

    $email = (new MailtrapEmail())
        ->from(new Address('hello@bullgym.com', 'Bull Gym Admin'))
        ->to(new Address($toEmail, $toName))
        ->subject($subject)
        ->text($message)
        ->html("
            <div style='font-family: Arial, sans-serif; max-width: 500px; margin: 0 auto; padding: 30px; background: #1a1a1a; color: #fff; border-radius: 10px;'>
                <h1 style='color: #dc3545; text-align: center;'>BULL GYM</h1>
                <h3 style='text-align: center;'>" . htmlspecialchars($subject) . "</h3>
                <div style='background: #222; padding: 20px; border-radius: 8px; margin: 20px 0;'>
                    <p style='line-height: 1.6;'>" . nl2br(htmlspecialchars($message)) . "</p>
                </div>
                <p style='text-align: center; color: #666; font-size: 12px;'>This email was sent from Bull Gym Administration.</p>
            </div>
        ")
        ->category('Admin Email');

    $response = $mailtrap->send($email);
    error_log("Admin email sent to $toEmail");
} catch (\Throwable $e) {
    error_log("Admin email failed: " . $e->getMessage());
}

header("Location: ../../pages/admin/dashboard.php");
exit();
?>
