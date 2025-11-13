<?php
include 'db.php';

$user_id = 1;

$total = $conn->query("SELECT COUNT(*) AS total FROM habits WHERE user_id = $user_id")->fetch_assoc()['total'];
$completed = $conn->query("SELECT COUNT(*) AS done FROM habits WHERE user_id = $user_id AND status = 1")->fetch_assoc()['done'];
$percent = $total > 0 ? round(($completed / $total) * 100) : 0;
$max_streak = $conn->query("SELECT MAX(best_streak) AS maxStreak FROM habits WHERE user_id = $user_id")->fetch_assoc()['maxStreak'] ?? 0;

echo json_encode([
  'total' => $total,
  'completed' => $completed,
  'percent' => $percent,
  'streak' => $max_streak
]);
?>
