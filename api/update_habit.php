<?php
include 'db.php';

$id = $_POST['id'];
$is_completed = $_POST['is_completed'];

$date = date('Y-m-d');

// Lấy thông tin thói quen
$sql = "SELECT current_streak, best_streak, start_date FROM habits WHERE habit_id = $id";
$res = $conn->query($sql)->fetch_assoc();
$current = $res['current_streak'];
$best = $res['best_streak'];
$start = $res['start_date'];

// Nếu vừa hoàn thành hôm nay thì tăng streak
if ($is_completed == 1) {
    $current++;
    if ($current > $best) $best = $current;
    $conn->query("UPDATE habits 
                  SET status = 1, current_streak = $current, best_streak = $best 
                  WHERE habit_id = $id");
} else {
    // Nếu bỏ tick, chỉ đặt lại status, không tăng streak
    $conn->query("UPDATE habits SET status = 0 WHERE habit_id = $id");
}

echo json_encode(["success" => true]);
?>
