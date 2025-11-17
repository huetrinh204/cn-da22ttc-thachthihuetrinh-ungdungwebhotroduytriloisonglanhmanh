<?php
session_start();
require "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Lấy user theo email
    $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([":email" => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        die("Email không tồn tại!");
    }

    // Kiểm tra mật khẩu
    if (!password_verify($password, $user["password"])) {
        die("Sai mật khẩu!");
    }

    // Lưu session đăng nhập
    $_SESSION["user_id"] = $user["user_id"];
    $_SESSION["username"] = $user["username"];
    $_SESSION["email"] = $user["email"];
    $_SESSION["role"] = $user["role"];

    // Cập nhật last_activity
    $pdo->prepare("UPDATE users SET last_activity = NOW() WHERE user_id = ?")
        ->execute([$user["user_id"]]);

    // Chuyển đến trang dashboard hoặc trang chủ
    header("Location: home.html");
    exit();
}
?>
