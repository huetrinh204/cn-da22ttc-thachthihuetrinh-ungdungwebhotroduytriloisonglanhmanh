<?php
require "config.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm = $_POST["confirm_password"];
    $gender = $_POST["gender"];
    $tel = $_POST["tel"];

    // Kiểm tra mật khẩu
    if ($password !== $confirm) {
        echo "<script>alert('Mật khẩu xác nhận không khớp!'); window.location.href='dangky.html';</script>";
        exit();
    }

    // Mã hóa mật khẩu
   // $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        $sql = "INSERT INTO users (username, email, password, gender, tel, role, create_acc)
                VALUES (:username, :email, :password, :gender, :tel, 'user', NOW())";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ":username" => $username,
            ":email" => $email,
            ":password" => $password,// nếu băm mk sửa chỗ này lại thành $$hashedPassword
            ":gender" => $gender,
            ":tel" => $tel
        ]);

        // Alert thành công và chuyển sang index.html
        echo "<script>alert('Đăng ký thành công!'); window.location.href='index.html';</script>";
        exit();

    } catch (PDOException $e) {
        echo "<script>alert('Lỗi đăng ký: " . $e->getMessage() . "'); window.location.href='dangky.html';</script>";
        exit();
    }
}
?>
