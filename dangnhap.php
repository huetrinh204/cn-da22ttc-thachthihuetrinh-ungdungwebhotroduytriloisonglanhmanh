<?php
session_start();
require "config.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Lấy user theo email
    $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([":email" => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "<script>alert('Email không tồn tại!'); window.location.href='dangnhap.html';</script>";
        exit();
    }

    // Kiểm tra mật khẩu
    if (!password_verify($password, $user["password"])) {
        echo "<script>alert('Sai mật khẩu!'); window.location.href='dangnhap.html';</script>";
        exit();
    }

    // Lưu session đăng nhập
    $_SESSION["user_id"] = $user["user_id"];
    $_SESSION["username"] = $user["username"];
    $_SESSION["email"] = $user["email"];
    $_SESSION["role"] = $user["role"];

    // Cập nhật last_activity
    $pdo->prepare("UPDATE users SET last_activity = NOW() WHERE user_id = ?")
        ->execute([$user["user_id"]]);

    // Chuyển đến dashboard.php (để hiển thị username)
    header("Location: dashboard.php");
    exit();
}
?>
