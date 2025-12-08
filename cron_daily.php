<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require "config.php";      // Kết nối PDO
require "send_mail.php";   // Hàm gửi mail

// Lấy tất cả user có thói quen chưa hoàn thành hôm nay
$sql = "
    SELECT u.email, u.username, h.habit_name
    FROM users u
    JOIN habit h ON h.user_id = u.user_id
    LEFT JOIN habit_logs l 
        ON l.habit_id = h.habit_id 
        AND DATE(l.log_date) = CURDATE()
    WHERE l.completed IS NULL OR l.completed = 0
";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$rows) {
    echo "Hôm nay tất cả người dùng đều đã hoàn thành thói quen 🎉";
    exit;
}

// Gửi mail cho từng người
foreach ($rows as $r) {

    $email   = $r["email"];
    $name    = $r["username"];
    $habit   = $r["habit_name"];

    $subject = "HABITU REMINDER !";
    
    $message = "
        <h3>Chào bạn, <b>$name</b>!</h3>
        <p>Bạn chưa hoàn thành thói quen: <b>$habit</b> hôm nay.</p>
        <p>Hãy vào Habitu tick ngay nhé! 💪🔥</p>
        <hr>
        <small>Habitu Reminder System</small>
    ";

    sendMail($email, $subject, $message);
}

echo "Đã gửi nhắc nhở cho tất cả người dùng chưa hoàn thành thói quen.";