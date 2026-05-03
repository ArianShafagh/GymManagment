<?php

use Mailtrap\Helper\ResponseHelper;
use Mailtrap\MailtrapClient;
use Mailtrap\Mime\MailtrapEmail;
use Symfony\Component\Mime\Address;

require __DIR__ . '/../vendor/autoload.php';

$apiKey = getenv('MailTrap_api_key');
$mailtrap = MailtrapClient::initSendingEmails(
    apiKey: $apiKey,
);

$email = (new MailtrapEmail())
    ->from(new Address('hello@ariangym.app', 'Mailtrap Test'))
    ->to(new Address("arian.shafagh2003@gmail.com"))
    ->subject('You are awesome!')
    ->text('Congrats for sending test email with Mailtrap!')
    ->category('Integration Test')
;

$response = $mailtrap->send($email);

var_dump(ResponseHelper::toArray($response));