<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Quản lý Bài Viết - Admin</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-tr from-cyan-300 to-sky-400 min-h-screen">

<!-- NAV -->
<?php include "navbar.php"; ?>

<div class="px-10 py-5">
    <h1 class="text-3xl font-bold" style="color:#ffffff; text-shadow: 2px 2px 6px rgba(0,0,0,0.5);">Quản Lý Bài Viết</h1>
    <p class="text-gray-700 mb-6">Theo dõi và quản lý tất cả bài viết của người dùng</p>

    <!-- Search + Filter -->
    <div class="flex flex-wrap gap-4 mb-6 items-center">
        <input type="text" placeholder="🔍 Tìm kiếm bài viết..."
               class="border border-gray-300 px-4 py-2 rounded-lg w-1/2 focus:outline-none">
        <button class="bg-gray-200 hover:bg-gray-300 px-3 py-1 rounded">Tất cả</button>
        <button class="bg-yellow-200 hover:bg-yellow-300 px-3 py-1 rounded">Bị báo cáo</button>
        <button class="bg-red-200 hover:bg-red-300 px-3 py-1 rounded">Đã xóa</button>
    </div>

    <!-- Post Table -->
    <div class="bg-white shadow rounded-lg p-5 overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b text-gray-700 font-bold">
                    <th class="py-2">Người Đăng</th>
                    <th>Nội Dung</th>
                    <th>Bình luận</th>
                    <th>Thời gian</th>
                    <th>Trạng thái</th>
                    <th class="text-center">Hành động</th>
                </tr>
            </thead>
            <tbody>
               <!-- Row 1 -->
<tr class="border-b hover:bg-gray-50">
    <td class="flex items-center gap-2 py-2">
        <div class="w-8 h-8 bg-pink-400 text-white rounded-full flex items-center justify-center font-bold">
            M
        </div>
        Minh Anh
    </td>
    <td>Mình đã hoàn thành 30 ngày liên tục tập thể dục! Cảm giác thật tuyệt vời 💪</td>
    <td>12</td>
    <td>10:30 14/11/2024</td>
    <td><span class="bg-green-100 text-green-600 px-2 py-1 rounded-full text-sm">Đã đăng</span></td>
    <td class="text-center text-lg">
        <i class="ri-edit-2-line text-blue-500 cursor-pointer mx-1"></i>
        <i class="ri-forbid-line text-yellow-500 cursor-pointer mx-1"></i>
        <i class="ri-delete-bin-6-line text-red-500 cursor-pointer mx-1"></i>
    </td>
</tr>

<!-- Row 2 -->
<tr class="border-b hover:bg-gray-50">
    <td class="flex items-center gap-2 py-2">
        <div class="w-8 h-8 bg-green-400 text-white rounded-full flex items-center justify-center font-bold">
            T
        </div>
        Tuấn Kiệt
    </td>
    <td>Ai có tips gì để duy trì thói quen đọc sách không? Mình hay bỏ lỡ 😅</td>
    <td>8</td>
    <td>09:15 14/11/2024</td>
    <td><span class="bg-green-100 text-green-600 px-2 py-1 rounded-full text-sm">Đã đăng</span></td>
    <td class="text-center text-lg">
        <i class="ri-edit-2-line text-blue-500 cursor-pointer mx-1"></i>
        <i class="ri-forbid-line text-yellow-500 cursor-pointer mx-1"></i>
        <i class="ri-delete-bin-6-line text-red-500 cursor-pointer mx-1"></i>
    </td>
</tr>

<!-- Row 3 -->
<tr class="border-b hover:bg-gray-50">
    <td class="flex items-center gap-2 py-2">
        <div class="w-8 h-8 bg-pink-300 text-white rounded-full flex items-center justify-center font-bold">
            T
        </div>
        Thu Hà
    </td>
    <td>Chào mọi người! Hôm nay mình muốn chia sẻ về hành trình giảm cân của mình...</td>
    <td>24</td>
    <td>16:45 13/11/2024</td>
    <td><span class="bg-green-100 text-green-600 px-2 py-1 rounded-full text-sm">Đã đăng</span></td>
    <td class="text-center text-lg">
        <i class="ri-edit-2-line text-blue-500 cursor-pointer mx-1"></i>
        <i class="ri-forbid-line text-yellow-500 cursor-pointer mx-1"></i>
        <i class="ri-delete-bin-6-line text-red-500 cursor-pointer mx-1"></i>
    </td>
</tr>

<!-- Row 4: Bị báo cáo -->
<tr class="border-b hover:bg-gray-50">
    <td class="flex items-center gap-2 py-2">
        <div class="w-8 h-8 bg-yellow-400 text-white rounded-full flex items-center justify-center font-bold">
            Đ
        </div>
        Đức Anh
    </td>
    <td>Nội dung không phù hợp vi phạm điều khoản cộng đồng</td>
    <td>2</td>
    <td>14:20 13/11/2024</td>
    <td><span class="bg-red-100 text-red-600 px-2 py-1 rounded-full text-sm">Bị báo cáo</span></td>
    <td class="text-center text-lg">
        <i class="ri-edit-2-line text-blue-500 cursor-pointer mx-1"></i>
        <i class="ri-forbid-line text-yellow-500 cursor-pointer mx-1"></i>
        <i class="ri-delete-bin-6-line text-red-500 cursor-pointer mx-1"></i>
    </td>
</tr>

<!-- Row 5 -->
<tr class="border-b hover:bg-gray-50">
    <td class="flex items-center gap-2 py-2">
        <div class="w-8 h-8 bg-purple-400 text-white rounded-full flex items-center justify-center font-bold">
            L
        </div>
        Lan Anh
    </td>
    <td>Streak 60 ngày rồi! Ai muốn kết bạn để cùng động viên nhau không? 🤝</td>
    <td>31</td>
    <td>11:00 13/11/2024</td>
    <td><span class="bg-green-100 text-green-600 px-2 py-1 rounded-full text-sm">Đã đăng</span></td>
    <td class="text-center text-lg">
        <i class="ri-edit-2-line text-blue-500 cursor-pointer mx-1"></i>
        <i class="ri-forbid-line text-yellow-500 cursor-pointer mx-1"></i>
        <i class="ri-delete-bin-6-line text-red-500 cursor-pointer mx-1"></i>
    </td>
</tr>

            </tbody>
        </table>
    </div>
</div>

</body>
</html>
