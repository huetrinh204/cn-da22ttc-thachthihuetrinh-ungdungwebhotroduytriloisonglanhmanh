<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: dangnhap.php");
    exit();
}

include "config.php"; 

$user_id = $_SESSION["user_id"];
$username = $_SESSION["username"];

// Lấy tất cả thói quen của user
$stmt = $pdo->prepare("SELECT * FROM habit WHERE user_id=?");
$stmt->execute([$user_id]);
$habits = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total_habits = count($habits);

// Streak hiện tại
$streak = 0;
foreach ($habits as $habit) {
    if ($habit['current_streak'] > $streak) $streak = $habit['current_streak'];
}

// Hiệu suất: tổng số log done / tổng số thói quen
$stmt = $pdo->prepare("SELECT COUNT(*) FROM habit_logs WHERE user_id=? AND completed='done'");
$stmt->execute([$user_id]);
$total_done = $stmt->fetchColumn();
$efficiency = $total_habits > 0 ? round($total_done / $total_habits * 100) : 0;

// -------- TẠO LOG HÔM NAY NẾU CHƯA CÓ --------
$today = date('Y-m-d');
foreach ($habits as $habit) {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM habit_logs WHERE user_id=? AND habit_id=? AND log_date=?");
    $stmt->execute([$user_id, $habit['habit_id'], $today]);
    if ($stmt->fetchColumn() == 0) {
        // Chưa có log hôm nay → tạo log chưa hoàn thành
        $stmt_insert = $pdo->prepare("INSERT INTO habit_logs(user_id, habit_id, log_date, completed) VALUES (?, ?, ?, '')");
        $stmt_insert->execute([$user_id, $habit['habit_id'], $today]);
    }
}

// Bar Chart
$bar_labels = [];
$bar_data = [];
foreach ($habits as $habit) {
    $bar_labels[] = $habit['habit_name'];
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM habit_logs WHERE habit_id=? AND user_id=? AND completed='done'");
    $stmt->execute([$habit['habit_id'], $user_id]);
    $bar_data[] = $stmt->fetchColumn();
}

// Pie Chart (hôm nay)
$stmt = $pdo->prepare("SELECT COUNT(*) FROM habit_logs WHERE user_id=? AND log_date=? AND completed='done'");
$stmt->execute([$user_id, $today]);
$done_today = $stmt->fetchColumn();

$stmt = $pdo->prepare("SELECT COUNT(*) FROM habit_logs WHERE user_id=? AND log_date=?");
$stmt->execute([$user_id, $today]);
$total_today = $stmt->fetchColumn();

$not_done_today = $total_today - $done_today;

// Line Chart tuần
$week_days = [];
$week_data = [];
for ($i = 6; $i >= 0; $i--) {
    $day = date('Y-m-d', strtotime("-$i day"));
    $week_days[] = date('D', strtotime($day));

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM habit_logs WHERE user_id=? AND log_date=? AND completed='done'");
    $stmt->execute([$user_id, $day]);
    $week_data[] = $stmt->fetchColumn();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thống Kê Thói Quen</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body style="background: linear-gradient(to right, #00c8ffb2, #006ef5c0)";>

<?php include "navbar.php"; ?>

<div class="mb-6 text-center mt-10">
    <h1 class="text-2xl font-bold text-white leading-loose">
        Thống Kê Thói Quen 📊
    </h1>
    <p class="text-sm text-white leading-relaxed">
        Xem tổng quan và tiến trình của bạn 🌟
    </p>
</div>

<section class="container mx-auto mt-10 px-4">
  <div class="bg-white/95 rounded-3xl shadow-xl p-7 max-w-5xl mx-auto">

    <div class="grid grid-cols-3 gap-4 justify-center mb-6">
      <div class="p-4 bg-teal-100 rounded-xl flex items-center gap-3">
        <i class="fa-solid fa-list-check text-teal-700 text-xl"></i>
        <div>
          <p class="text-sm text-gray-600">Tổng thói quen</p>
          <p class="font-bold text-lg"><?= $total_habits ?></p>
        </div>
      </div>

      <div class="p-4 bg-purple-100 rounded-xl flex items-center gap-3">
        <i class="fa-solid fa-bolt text-purple-700 text-xl"></i>
        <div>
          <p class="text-sm text-gray-600">Streak hiện tại</p>
          <p class="font-bold text-lg"><?= $streak ?> ngày</p>
        </div>
      </div>

      <div class="p-4 bg-blue-100 rounded-xl flex items-center gap-3">
        <i class="fa-solid fa-percent text-blue-700 text-xl"></i>
        <div>
          <p class="text-sm text-gray-600">Hiệu suất</p>
          <p class="font-bold text-lg"><?= $efficiency ?>%</p>
        </div>
      </div>
    </div>

    <!-- CHARTS SECTION -->
    <div class="grid grid-cols-2 gap-6">
      <div class="bg-white shadow-md p-4 rounded-xl border">
        <h3 class="font-semibold text-gray-700 mb-3">Chuỗi ngày theo thói quen</h3>
        <canvas id="barChart"></canvas>
      </div>

      <div class="bg-white shadow-md p-4 rounded-xl border">
        <h3 class="font-semibold text-gray-700 mb-3">Tỷ lệ hoàn thành hôm nay</h3>
        <canvas id="pieChart"></canvas>
      </div>
    </div>

    <div class="bg-white shadow-md p-4 rounded-xl border mt-6">
      <h3 class="font-semibold text-gray-700 mb-3">Tiến độ tuần này</h3>
      <canvas id="lineChart"></canvas>
    </div>

    <div class="bg-white shadow-md p-4 rounded-xl border mt-6">
      <h3 class="font-semibold text-gray-700 mb-4">Chi tiết thói quen</h3>
      <div class="space-y-4">
        <?php foreach ($habits as $habit): 
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM habit_logs WHERE habit_id=? AND user_id=? AND completed='done'");
            $stmt->execute([$habit['habit_id'], $user_id]);
            $done_count = $stmt->fetchColumn();

            $stmt = $pdo->prepare("SELECT COUNT(*) FROM habit_logs WHERE habit_id=? AND user_id=?");
            $stmt->execute([$habit['habit_id'], $user_id]);
            $total_count = $stmt->fetchColumn();
        ?>
        <div class="flex justify-between items-center">
          <div class="flex items-center gap-3">
            <i class="fa-solid <?= $habit['icon'] ?> text-blue-600"></i>
            <span><?= $habit['habit_name'] ?></span>
          </div>
          <span class="text-sm text-gray-500"><?= $done_count ?>/<?= $total_count ?> ngày</span>
        </div>
        <?php endforeach; ?>
      </div>
    </div>

  </div>
</section>

<script>
  new Chart(document.getElementById("barChart"), {
    type: "bar",
    data: {
      labels: <?= json_encode($bar_labels) ?>,
      datasets: [{
        label: "Số ngày duy trì",
        data: <?= json_encode($bar_data) ?>,
        backgroundColor: ["#14b8a6", "#3b82f6", "#f97316"]
      }]
    },
    options: { responsive: true }
  });

  new Chart(document.getElementById("pieChart"), {
    type: "pie",
    data: {
      labels: ["Đã hoàn thành", "Chưa hoàn thành"],
      datasets: [{
        data: [<?= $done_today ?>, <?= $not_done_today ?>],
        backgroundColor: ["#10b981", "#f97316"]
      }]
    }
  });

  new Chart(document.getElementById("lineChart"), {
    type: "line",
    data: {
      labels: <?= json_encode($week_days) ?>,
      datasets: [{
        label: "Thói quen hoàn thành",
        data: <?= json_encode($week_data) ?>,
        borderColor: "#14b8a6",
        fill: false,
        tension: 0.3
      }]
    }
  });
</script>

</body>
</html>
