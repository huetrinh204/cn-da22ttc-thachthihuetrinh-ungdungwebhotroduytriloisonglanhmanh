<?php
include 'db.php';

$user_id = 1; // tạm thời, sau này lấy từ session đăng nhập

$sql = "SELECT habit_id, habit_name, description, icon, status, current_streak, best_streak
        FROM habits WHERE user_id = $user_id";
$result = $conn->query($sql);

$habits = [];
while ($row = $result->fetch_assoc()) {
  $habits[] = $row;
}

echo json_encode($habits);
?>
