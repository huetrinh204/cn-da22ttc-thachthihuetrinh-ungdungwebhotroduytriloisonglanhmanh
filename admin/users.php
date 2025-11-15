<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Quản lý người dùng - Admin</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
</head>

<body class="bg-gradient-to-tr from-cyan-300 to-sky-400 min-h-screen">

<!-- NAV -->
<?php include "navbar.php"; ?> <!-- Nếu dùng chung navbar, không thì bỏ -->

<div class="px-10 py-5">
    <h1 class="text-3xl font-bold" style="color:#ffffff; text-shadow: 2px 2px 6px rgba(0,0,0,0.5);">Quản Lý Người Dùng</h1>
    <p class="text-gray-700 mb-6">Quản lý và theo dõi hoạt động người dùng</p>

    <!-- Stats -->
    <div class="grid grid-cols-4 gap-6 mb-6">
        <div class="bg-white shadow rounded-lg p-5 text-center">
            <p class="text-gray-500">Tổng người dùng</p>
            <h2 class="text-3xl font-bold text-blue-600">5</h2>
        </div>
        <div class="bg-white shadow rounded-lg p-5 text-center">
            <p class="text-gray-500">Đang hoạt động</p>
            <h2 class="text-3xl font-bold text-green-600">4</h2>
        </div>
        <div class="bg-white shadow rounded-lg p-5 text-center">
            <p class="text-gray-500">Không hoạt động</p>
            <h2 class="text-3xl font-bold text-orange-500">1</h2>
        </div>
        <div class="bg-white shadow rounded-lg p-5 text-center">
            <p class="text-gray-500">Đã chặn</p>
            <h2 class="text-3xl font-bold text-red-600">0</h2>
        </div>
    </div>

    <!-- Search + Button -->
    <div class="bg-white shadow rounded-lg p-5">
        <div class="flex justify-between mb-4">
            <input type="text" placeholder="🔍 Tìm kiếm theo tên hoặc email..."
                   class="border border-gray-300 px-4 py-2 rounded-lg w-2/3 focus:outline-none">
            <button class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded shadow">
                Xuất Excel
            </button>
        </div>

        <!-- User Table -->
        <table class="w-full text-left">
            <thead>
                <tr class="border-b text-gray-700 font-bold">
                    <th class="py-2">Người dùng</th>
                    <th>Email</th>
                    <th>Ngày tham gia</th>
                    <th>Trạng thái</th>
                    <th>Thói quen</th>
                    <th>Streak</th>
                    <th>Bài viết</th>
                    <th class="text-center">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <!-- Row -->
                <tr class="border-b hover:bg-gray-50">
                    <td class="flex items-center gap-2 py-2">
                       <div class="w-8 h-8 bg-blue-400 text-white rounded-full flex items-center justify-center font-bold">
        M
    </div>
                        Minh Anh
                    </td>
                    <td>minhanh@example.com</td>
                    <td>15/1/2024</td>
                    <td><span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-sm">Hoạt động</span></td>
                    <td>8</td>
                    <td>🔥 45</td>
                    <td>12</td>
                    <td class="text-center text-lg">
                        <i class="ri-edit-2-line text-blue-500 cursor-pointer mx-1"></i>
                        <i class="ri-forbid-line text-yellow-500 cursor-pointer mx-1"></i>
                        <i class="ri-delete-bin-6-line text-red-500 cursor-pointer mx-1"></i>
                    </td>
                </tr>

                <!-- (Bạn có thể copy thêm row hoặc sau này dùng PHP loop) -->

            </tbody>
        </table>
    </div>
</div>

</body>
</html>
