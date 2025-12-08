<?php
require 'vendor/autoload.php';

$client = new Google_Client();
$client->setClientId("58707631760-jdnhnoscf1fl80kbn5dk41pgm2go9ebo.apps.googleusercontent.com");
$client->setClientSecret("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");
$client->setRedirectUri("http://localhost/habitu/google-callback.php");

$client->addScope("email");
$client->addScope("profile");