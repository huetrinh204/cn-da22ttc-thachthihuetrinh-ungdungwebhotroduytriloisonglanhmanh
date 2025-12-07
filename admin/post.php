<?php
session_start();
include "../config.php";

// Kiểm tra đăng nhập
if (!isset($_SESSION["user_id"])) {
    header("Location: dangnhap.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$username = $_SESSION["username"];

// Lấy quyền user
$stmt = $pdo->prepare("SELECT role FROM users WHERE user_id = ?");
$stmt->execute([$user_id]);
$role = $stmt->fetchColumn();

// Nếu không phải admin → không cho truy cập
if ($role !== "admin") {
    header("Location: ../index.php");
    exit();
}



// =========================
// XÓA BÀI VIẾT 
// =========================
if (isset($_GET["action"]) && $_GET["action"] == "deletePost") {
    header("Content-Type: application/json; charset=UTF-8");

    $post_id = $_POST["post_id"] ?? null;

    if ($post_id) {
        $stmt = $pdo->prepare("DELETE FROM post WHERE post_id=?");
        $stmt->execute([$post_id]);

        echo json_encode(["status" => "deleted"]);
    } else {
        echo json_encode(["status" => "error"]);
    }
    exit;
}

// =========================
// LẤY DANH SÁCH BÀI VIẾT
// =========================
$stmt = $pdo->query("
    SELECT p.*, u.username 
    FROM post p
    JOIN users u ON u.user_id = p.user_id
    ORDER BY p.created_at DESC
");
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
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
    <h1 class="text-3xl font-bold" style="color:#ffffff; text-shadow: 2px 2px 6px rgba(0,0,0,0.5);">
        Quản Lý Bài Viết
    </h1>
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
            <?php foreach ($posts as $p): ?>

                <?php
                // Avatar ký tự đầu
                $avatar = strtoupper(substr($p['username'], 0, 1));

                // Đếm số bình luận
                $stmtC = $pdo->prepare("SELECT COUNT(*) FROM comment WHERE post_id=?");
                $stmtC->execute([$p["post_id"]]);
                $commentCount = $stmtC->fetchColumn();

                // Trạng thái (tạm thời mặc định)
                $status = "<span class='bg-green-100 text-green-600 px-2 py-1 rounded-full text-sm'>Đã đăng</span>";
                ?>

                <tr class="border-b hover:bg-gray-50">
                    <td class="flex items-center gap-2 py-2">
                        <div class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center font-bold">
                            <?= $avatar ?>
                        </div>
                        <?= htmlspecialchars($p['username']) ?>
                    </td>

                    <td><?= htmlspecialchars($p['content']) ?></td>

                    <td><?= $commentCount ?></td>

                    <td><?= date("H:i d/m/Y", strtotime($p["created_at"])) ?></td>

                    <td><?= $status ?></td>

                    <td class="text-center text-lg">
                        <i class="ri-delete-bin-6-line text-red-500 cursor-pointer mx-1"
                           onclick="deletePost(<?= $p['post_id'] ?>)"></i>
                    </td>
                </tr>

            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- JS DELETE -->
<script>
function deletePost(id) {
    if (!confirm("Bạn có chắc muốn xóa bài viết này?")) return;

    fetch("post.php?action=deletePost", {
        method: "POST",
        body: new URLSearchParams({ post_id: id })
    })
    .then(res => res.json())
    .then(() => location.reload());
}
</script>

</body>
</html>
