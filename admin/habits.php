<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Quản lý Thói Quen - Admin</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-tr from-cyan-300 to-sky-400 min-h-screen">

<!-- NAV -->
<?php include "navbar.php"; ?>

<div class="px-10 py-5">
    <h1 class="text-3xl font-bold" style="color:#ffffff; text-shadow:2px 2px 6px rgba(0,0,0,0.5)">Quản Lý Thói Quen</h1>
    <p class="text-gray-700 mb-6">Quản lý thói quen của người dùng và tạo thói quen mẫu</p>

    <!-- Stats -->
    <div class="grid grid-cols-4 gap-6 mb-6">
        <div class="bg-white shadow rounded-lg p-5 text-center">
            <p class="text-gray-500">Tổng thói quen</p>
            <h2 class="text-3xl font-bold text-blue-600">8</h2>
        </div>
        <div class="bg-white shadow rounded-lg p-5 text-center">
            <p class="text-gray-500">Thói quen mẫu</p>
            <h2 class="text-3xl font-bold text-green-600">5</h2>
        </div>
        <div class="bg-white shadow rounded-lg p-5 text-center">
            <p class="text-gray-500">Tổng người dùng</p>
            <h2 class="text-3xl font-bold text-orange-500">16.955</h2>
        </div>
        <div class="bg-white shadow rounded-lg p-5 text-center">
            <p class="text-gray-500">Tổng hoàn thành</p>
            <h2 class="text-3xl font-bold text-red-600">227.266</h2>
        </div>
    </div>

    <!-- Search + Filter -->
    <div class="flex flex-wrap gap-4 mb-6 items-center">
        <input type="text" placeholder="🔍 Tìm kiếm thói quen..."
               class="border border-gray-300 px-4 py-2 rounded-lg w-1/2 focus:outline-none">
        <button class="bg-gray-200 hover:bg-gray-300 px-3 py-1 rounded">Tất cả</button>
        <button class="bg-yellow-200 hover:bg-yellow-300 px-3 py-1 rounded">Mẫu</button>
        <button class="bg-green-200 hover:bg-green-300 px-3 py-1 rounded">Hoạt động</button>
        <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded ml-auto">Tạo Thói Quen Mẫu</button>
    </div>

    <!-- Habits Table -->
    <div class="bg-white shadow rounded-lg p-5 overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b text-gray-700 font-bold">
                    <th class="py-2">Thói quen</th>
                    
                    <th>Trạng thái</th>
                    <th>Người tạo</th>
                    <th>Người dùng</th>
                    <th>Hoàn thành</th>
                    <th>Streak TB</th>
                    <th class="text-center">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b hover:bg-gray-50">
                    <td class="flex items-center gap-2 py-2">
                        <div class="w-8 h-8 bg-blue-400 text-white rounded-full flex items-center justify-center font-bold">💧</div>
                        Uống 8 ly nước
                    </td>
               
                    <td>Mẫu</td>
                    <td>System</td>
                    <td>3.245</td>
                    <td>45.678</td>
                    <td>🔥 23</td>
                    <td class="text-center text-lg">
                        <i class="ri-edit-2-line text-blue-500 cursor-pointer mx-1"></i>
                        <i class="ri-delete-bin-6-line text-red-500 cursor-pointer mx-1"></i>
                    </td>
                </tr>

                <tr class="border-b hover:bg-gray-50">
                    <td class="flex items-center gap-2 py-2">
                        <div class="w-8 h-8 bg-red-400 text-white rounded-full flex items-center justify-center font-bold">🔥</div>
                        Tập thể dục 30 phút
                    </td>
           
                    <td>Mẫu</td>
                    <td>System</td>
                    <td>2.891</td>
                    <td>38.902</td>
                    <td>🔥 18</td>
                    <td class="text-center text-lg">
                        <i class="ri-edit-2-line text-blue-500 cursor-pointer mx-1"></i>
                        <i class="ri-delete-bin-6-line text-red-500 cursor-pointer mx-1"></i>
                    </td>
                </tr>

                <tr class="border-b hover:bg-gray-50">
                    <td class="flex items-center gap-2 py-2">
                        <div class="w-8 h-8 bg-yellow-400 text-white rounded-full flex items-center justify-center font-bold">📚</div>
                        Đọc sách 20 phút
                    </td>
             
                    <td>Mẫu</td>
                    <td>System</td>
                    <td>2.456</td>
                    <td>32.145</td>
                    <td>🔥 15</td>
                    <td class="text-center text-lg">
                        <i class="ri-edit-2-line text-blue-500 cursor-pointer mx-1"></i>
                        <i class="ri-delete-bin-6-line text-red-500 cursor-pointer mx-1"></i>
                    </td>
                </tr>

                 <tr class="border-b hover:bg-gray-50">
                    <td class="flex items-center gap-2 py-2">
                        <div class="w-8 h-8 bg-yellow-400 text-white rounded-full flex items-center justify-center font-bold">📚</div>
                        Nhảy dây
                    </td>
             
                    <td>Hoạt động</td>
                    <td>Minh Anh</td>
                    <td>111</td>
                    <td>11</td>
                    <td>🔥 10</td>
                    <td class="text-center text-lg">
                        <i class="ri-edit-2-line text-blue-500 cursor-pointer mx-1"></i>
                        <i class="ri-delete-bin-6-line text-red-500 cursor-pointer mx-1"></i>
                    </td>
                </tr>

                <!-- Có thể tiếp tục thêm các thói quen khác tương tự -->

            </tbody>
        </table>
    </div>
</div>

</body>
</html>
