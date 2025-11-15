<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Admin Dashboard - Habitu</title>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body class="bg-gradient-to-tr from-cyan-300 to-sky-400">

<!-- NAV -->
<nav class="flex justify-between px-8 py-3 items-center bg-gradient-to-r from-purple-600 to-pink-500 text-white shadow-lg">
    <div class="flex items-center gap-3">
        <img style="border-radius: 60%" src="assets/images/logo_habitu.png" width="38">
        <h2 class="text-xl font-bold">Habitu <span class="bg-yellow-400 text-black px-2 py-0.5 rounded text-sm ml-2">ADMIN</span></h2>
    </div>

    <ul class="flex gap-8 font-medium">
        <li class="flex items-center gap-1">
            <i class="fas fa-tachometer-alt"></i>
            <a href="index.php" class="hover:text-yellow-300 transition">Dashboard</a>
        </li>
        <li class="flex items-center gap-1">
            <i class="fas fa-user"></i>
            <a href="users.php" class="hover:text-yellow-300 transition">Người Dùng</a>
        </li>
        <li class="flex items-center gap-1">
            <i class="fas fa-file-alt"></i>
            <a href="post.php" class="hover:text-yellow-300 transition">Bài Viết</a>
        </li>
        <li class="flex items-center gap-1">
            <i class="fas fa-redo"></i>
            <a href="#" class="hover:text-yellow-300 transition">Thói Quen</a>
        </li>
        <li class="flex items-center gap-1">
            <i class="fas fa-cog"></i>
            <a href="#" class="hover:text-yellow-300 transition">Cài Đặt</a>
        </li>
    </ul>

    <div class="flex items-center gap-2">
        <i class="fas fa-user-circle text-xl"></i>
        <span>Admin</span>
    </div>
</nav>


<!-- MAIN CONTENT -->
<div class="px-10 py-5 text-gray-800">

   <h1 class="text-3xl font-bold" style="color:#ffffff; text-shadow: 2px 2px 6px rgba(0,0,0,0.5);">
    Dashboard
</h1>
    <p class="text-gray-700 mb-6">Tổng quan hệ thống Habitu</p>

    <!-- METRIC CARDS -->
    <div class="grid grid-cols-4 gap-6">
        <div class="bg-white shadow rounded-lg p-5">
            <p class="text-gray-600">Tổng Người Dùng</p>
            <h2 class="text-3xl font-bold">10,234</h2>
            <p class="text-green-500 text-sm font-medium mt-1">+12.5% so với tháng trước</p>
        </div>

        <div class="bg-white shadow rounded-lg p-5">
            <p class="text-gray-600">Bài Viết</p>
            <h2 class="text-3xl font-bold">1,567</h2>
            <p class="text-green-500 text-sm font-medium mt-1">+8.2% so với tháng trước</p>
        </div>

        <div class="bg-white shadow rounded-lg p-5">
            <p class="text-gray-600">Thói Quen Hoạt Động</p>
            <h2 class="text-3xl font-bold">45,892</h2>
            <p class="text-green-500 text-sm font-medium mt-1">+23.1% so với tháng trước</p>
        </div>

        <div class="bg-white shadow rounded-lg p-5">
            <p class="text-gray-600">Người Dùng Hoạt Động</p>
            <h2 class="text-3xl font-bold">8,921</h2>
            <p class="text-green-500 text-sm font-medium mt-1">+5.4% so với tháng trước</p>
        </div>
    </div>

    <!-- CHARTS -->
    <div class="grid grid-cols-2 gap-6 mt-6">
        <div class="bg-white shadow rounded-lg p-5">
            <h3 class="font-semibold mb-3">Tăng Trưởng Người Dùng</h3>
            <canvas id="growthChart"></canvas>
        </div>

        <div class="bg-white shadow rounded-lg p-5">
            <h3 class="font-semibold mb-3">Hoạt Động Thói Quen (7 ngày)</h3>
            <canvas id="activityChart"></canvas>
        </div>
    </div>

    <!-- PIE + TOP HABITS -->
    <div class="grid grid-cols-2 gap-6 mt-6">
        <div class="bg-white shadow rounded-lg p-5">
            <h3 class="font-semibold mb-3">Danh Mục Thói Quen</h3>
            <canvas id="pieChart"></canvas>
        </div>

        <div class="bg-white shadow rounded-lg p-5">
            <h3 class="font-semibold mb-3">Top Thói Quen Phổ Biến</h3>

            <div class="mb-3">
                <p>🥤 Uống 8 ly nước</p>
                <div class="w-full mt-1 bg-gray-200 rounded h-2">
                    <div class="bg-cyan-500 h-2 rounded" style="width:82%"></div>
                </div>
            </div>

            <div class="mb-3">
                <p>🏃 Tập thể dục 30 phút</p>
                <div class="w-full mt-1 bg-gray-200 rounded h-2">
                    <div class="bg-cyan-500 h-2 rounded" style="width:75%"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/charts.js"></script>
</body>
</html>
