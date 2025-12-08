<?php
session_start();
require 'config_google.php';
require 'config.php';

if (isset($_GET['code'])) {

    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token);

    $googleService = new Google_Service_Oauth2($client);
    $gUser = $googleService->userinfo->get();

    $google_id = $gUser->id;
    $name = $gUser->name;
    $email = $gUser->email;
    $avatar = $gUser->picture;

    // Kiểm tra user có tồn tại chưa
    $stmt = $pdo->prepare("SELECT * FROM users WHERE google_id = ?");
    $stmt->execute([$google_id]);

    if ($stmt->rowCount() == 0) {
        // Nếu chưa có → tạo mới
        $ins = $pdo->prepare("INSERT INTO users (google_id, username, email, avatar, role)
                              VALUES (?, ?, ?, ?, 'user')");
        $ins->execute([$google_id, $name, $email, $avatar]);
    }

    // Lấy lại thông tin user
    $stmt = $pdo->prepare("SELECT * FROM users WHERE google_id = ?");
    $stmt->execute([$google_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Lưu session
    $_SESSION["user_id"] = $user["user_id"];
    $_SESSION["username"] = $user["username"];
    $_SESSION["email"] = $user["email"];
    $_SESSION["role"] = $user["role"];

    header("Location: index.php");
    exit();
}
