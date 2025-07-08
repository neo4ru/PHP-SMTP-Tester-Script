<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // if using Composer

$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host = '127.0.0.1';       // Mercury SMTP runs on localhost
    $mail->Port = 25;                // Default SMTP port
    $mail->SMTPAuth = false;
    $mail->Username = 'ceo';         // Mercury user
    $mail->Password = 'ceo';    // Mercury password

    // Sender and recipient
    $mail->setFrom('neo@localhost.com', 'Neo Test');
    $mail->addAddress('neo@localhost.com'); // Sending to the local Mercury user

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Local Mercury Mail Test';
    $mail->Body    = 'Hello, this is a test message from PHPMailer via Mercury SMTP!';

    $mail->send();
    echo 'Message has been sent successfully';

} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
