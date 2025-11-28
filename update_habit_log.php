<?php
session_start();
include "config.php";

$data = json_decode(file_get_contents('php://input'), true);
$habitId = $data['habitId'];
$completed = $data['completed'];
$userId = $_SESSION['user_id'];
$today = date('Y-m-d');

// -------------------- 1. Kiểm tra log hôm nay --------------------
$stmt = $pdo->prepare("SELECT * FROM habit_logs WHERE habit_id=? AND user_id=? AND log_date=?");
$stmt->execute([$habitId, $userId, $today]);
$log = $stmt->fetch(PDO::FETCH_ASSOC);

if ($log) {
    $stmt = $pdo->prepare("UPDATE habit_logs SET completed=? WHERE habit_id=? AND user_id=? AND log_date=?");
    $stmt->execute([$completed, $habitId, $userId, $today]);
} else {
    $stmt = $pdo->prepare("INSERT INTO habit_logs (habit_id, user_id, log_date, completed) VALUES (?,?,?,?)");
    $stmt->execute([$habitId, $userId, $today, $completed]);
}

// -------------------- 2. Tính streak cho thói quen này --------------------
// Lấy current_streak và last_completed_date
$stmt = $pdo->prepare("SELECT current_streak, last_completed_date FROM habit WHERE habit_id=?");
$stmt->execute([$habitId]);
$habit = $stmt->fetch(PDO::FETCH_ASSOC);

$current_streak = isset($habit['current_streak']) ? (int)$habit['current_streak'] : 0;
$last_completed = $habit['last_completed_date'] ?? null;

if ($completed == 'done') {
    if ($last_completed != $today) {
        // Nếu tick hôm nay lần đầu
        if ($last_completed == date('Y-m-d', strtotime('-1 day'))) {
            $current_streak += 1; // tăng streak liên tiếp
        } else {
            $current_streak = 1; // bắt đầu streak mới
        }

        $stmt = $pdo->prepare("UPDATE habit SET current_streak=?, last_completed_date=? WHERE habit_id=?");
        $stmt->execute([$current_streak, $today, $habitId]);
    }
} else {
    // Nếu bỏ tick, không giảm current_streak, chỉ xóa last_completed_date hôm nay
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM habit_logs WHERE habit_id=? AND user_id=? AND log_date=? AND completed='done'");
    $stmt->execute([$habitId, $userId, $today]);
    $done_count = (int)$stmt->fetchColumn();

    if ($done_count === 0) {
        $stmt = $pdo->prepare("UPDATE habit SET last_completed_date=NULL WHERE habit_id=?");
        $stmt->execute([$habitId]);
    }
}

// -------------------- 3. Tính tổng chuỗi ngày --------------------
$stmt = $pdo->prepare("
    SELECT SUM(current_streak) 
    FROM habit 
    WHERE (status='Người dùng' AND user_id=?) OR (status='Mẫu' AND current_streak IS NOT NULL)
");
$stmt->execute([$userId]);
$total_streak = (int)$stmt->fetchColumn();

// -------------------- 4. Tính completed hôm nay --------------------
$stmt = $pdo->prepare("
    SELECT COUNT(*) 
    FROM habit_logs hl
    JOIN habit h ON hl.habit_id = h.habit_id
    WHERE hl.user_id=? AND hl.log_date=? AND hl.completed='done'
      AND (h.status='Mẫu' OR (h.status='Người dùng' AND h.user_id=?))
");
$stmt->execute([$userId, $today, $userId]);
$completed_today = (int)$stmt->fetchColumn();

// -------------------- 5. Tổng thói quen --------------------
$stmt = $pdo->prepare("SELECT COUNT(*) FROM habit WHERE status='Mẫu' OR (status='Người dùng' AND user_id=?)");
$stmt->execute([$userId]);
$total_habits = (int)$stmt->fetchColumn();

// -------------------- 6. Trả JSON --------------------
echo json_encode([
    'success' => true,
    'current_streak' => $current_streak,
    'total_streak' => $total_streak,
    'completed_today' => $completed_today,
    'total_habits' => $total_habits
]);
