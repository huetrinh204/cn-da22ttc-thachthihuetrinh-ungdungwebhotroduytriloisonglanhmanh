<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\OAuth;
use League\OAuth2\Client\Provider\Google;

function sendMail($toEmail, $subject, $htmlMessage)
{
    // Load config
    $config = require 'config_mail.php';

    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;

    // OAuth2 Config
    $mail->AuthType = 'XOAUTH2';
    $mail->setOAuth(new OAuth([
        'provider' => new Google([
            'clientId'     => $config['client_id'],
            'clientSecret' => $config['client_secret'],
        ]),
        'clientId'     => $config['client_id'],
        'clientSecret' => $config['client_secret'],
        'refreshToken' => $config['refresh_token'],
        'userName'     => $config['email'],  
    ]));

    // From
    $mail->setFrom($config['email'], 'Habitu Reminder');

    // Email content
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body    = $htmlMessage;

    // Receiver
    $mail->addAddress($toEmail);

    // Send mail
    return $mail->send();
}
