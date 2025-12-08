<?php
require 'vendor/autoload.php';

$client = new Google_Client();
$client->setClientId('58707631760-jdnhnoscf1fl80kbn5dk41pgm2go9ebo.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('http://localhost/habitu/get_token.php');

// Scope Gmail
$client->addScope('https://mail.google.com/');
$client->setAccessType('offline');
$client->setPrompt('consent');

// Nếu chưa có code → chuyển sang Google đăng nhập
if (!isset($_GET['code'])) {
    $authUrl = $client->createAuthUrl();
    header('Location: ' . $authUrl);
    exit();
} 

// Nếu Google trả về code → lấy token
$token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

echo "<pre>";
print_r($token);
echo "</pre>";
