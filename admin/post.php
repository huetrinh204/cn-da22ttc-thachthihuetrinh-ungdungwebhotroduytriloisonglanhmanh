<?php
session_start();
include "../config.php";

// =========================
// KIỂM TRA ĐĂNG NHẬP + ROLE
// =========================
if (!isset($_SESSION["user_id"])) {
    header("Location: dangnhap.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$username = $_SESSION["username"];

$stmt = $pdo->prepare("SELECT role FROM users WHERE user_id = ?");
$stmt->execute([$user_id]);
$role = $stmt->fetchColumn();

if ($role !== "admin") {
    header("Location: ../index.php");
    exit();
}


// =====================================
// API: LẤY DANH SÁCH BÌNH LUẬN
// =====================================
if (isset($_GET["action"]) && $_GET["action"] === "getComments") {
    header("Content-Type: application/json; charset=UTF-8");

    $post_id = $_GET["post_id"] ?? 0;

    $stmt = $pdo->prepare("
        SELECT c.cmt_id, c.content_cmt, c.created_cmt, u.username 
        FROM comment c 
        JOIN users u ON u.user_id = c.user_id
        WHERE c.post_id = ?
        ORDER BY c.created_cmt DESC
    ");
    $stmt->execute([$post_id]);

    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    exit;
}


// =====================================
// API: XÓA BÌNH LUẬN
// =====================================
if (isset($_GET["action"]) && $_GET["action"] === "deleteComment") {
    header("Content-Type: application/json; charset=UTF-8");

    $cid = $_POST["cmt_id"] ?? null;

    if ($cid) {
        $stmt = $pdo->prepare("DELETE FROM comment WHERE cmt_id=?");
        $stmt->execute([$cid]);

        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error"]);
    }
    exit;
}


// =====================================
// API: XÓA BÀI VIẾT
// =====================================
if (isset($_GET["action"]) && $_GET["action"] === "deletePost") {
    header("Content-Type: application/json; charset=UTF-8");

    $pid = $_POST["post_id"] ?? null;

    if ($pid) {
        $pdo->prepare("DELETE FROM comment WHERE post_id=?")->execute([$pid]);
        $pdo->prepare("DELETE FROM post WHERE post_id=?")->execute([$pid]);

        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error"]);
    }
    exit;
}


// =====================================
// LẤY TẤT CẢ BÀI VIẾT
// =====================================
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
    <meta charset="UTF-8">
    <title>Quản lý Bài Viết</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
</head>

<body class="bg-gradient-to-tr from-cyan-300 to-sky-400 min-h-screen">

    <?php include "navbar.php"; ?>

    <div class="px-4 md:px-10 py-5">
        <h1 class="text-2xl md:text-3xl font-bold text-white drop-shadow-lg">
            Quản Lý Bài Viết
        </h1>
        <p class="text-gray-700 mb-6 text-sm md:text-base">
            Theo dõi và quản lý tất cả bài viết
        </p>

        <!-- BẢNG RESPONSIVE -->
        <div class="bg-white shadow rounded-lg p-3 md:p-5 overflow-x-auto">

            <table class="min-w-[900px] w-full text-left border-collapse">
                <thead>
                    <tr class="border-b bg-gray-100 text-gray-700 font-semibold text-sm md:text-base">
                        <th class="py-3 px-3">Người đăng</th>
                        <th class="py-3 px-3 w-[400px]">Nội dung</th>
                        <th class="py-3 px-3 text-center">Bình luận</th>
                        <th class="py-3 px-3">Thời gian</th>
                        <th class="py-3 px-3">Trạng thái</th>
                        <th class="py-3 px-3 text-center">Hành động</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($posts as $p): ?>
                        <?php
                        $avatar = strtoupper(substr($p["username"], 0, 1));
                        $cmt = $pdo->prepare("SELECT COUNT(*) FROM comment WHERE post_id=?");
                        $cmt->execute([$p["post_id"]]);
                        $commentCount = $cmt->fetchColumn();
                        ?>
                        <tr class="border-b hover:bg-gray-50 transition">

                            <!-- Người đăng -->
                            <td class="py-4 px-3 flex items-center gap-3">
                                <div
                                    class="w-10 h-10 bg-blue-500 text-white rounded-full flex justify-center items-center font-bold text-lg shadow">
                                    <?= $avatar ?>
                                </div>

                                <div class="font-semibold">
                                    <?= htmlspecialchars($p["username"]) ?>
                                </div>
                            </td>

                            <!-- Nội dung -->
                            <td class="py-4 px-3 align-top">
                                <div class="text-gray-800 break-words leading-relaxed text-justify">
                                    <?= nl2br(htmlspecialchars(trim($p["content"]))) ?>
                                </div>
                            </td>

                            <!-- Số bình luận -->
                            <td class="py-4 px-3 text-center font-bold text-blue-500">
                                <?= $commentCount ?>
                            </td>

                            <!-- Thời gian -->
                            <td class="py-4 px-3 text-gray-600 whitespace-nowrap">
                                <?= date("H:i d/m/Y", strtotime($p["created_at"])) ?>
                            </td>

                            <!-- Trạng thái -->
                            <td class="py-4 px-3">
                                <span
                                    class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm font-medium shadow-sm">
                                    Đã đăng
                                </span>
                            </td>

                            <!-- Hành động -->
                            <td class="py-4 px-3 text-center">
                                <div class="flex items-center justify-center gap-4 text-xl">

                                    <!-- Xem bình luận -->
                                    <i class="ri-chat-history-line text-blue-500 cursor-pointer hover:scale-110 transition"
                                        onclick="openComments(<?= $p['post_id'] ?>)"></i>

                                    <!-- Xóa -->
                                    <i class="ri-delete-bin-6-line text-red-500 cursor-pointer hover:scale-110 transition"
                                        onclick="deletePost(<?= $p['post_id'] ?>)"></i>

                                </div>
                            </td>
                        </tr>

                    <?php endforeach; ?>
                </tbody>
            </table>


        </div>
    </div>

    <!-- POPUP BÌNH LUẬN -->
    <div id="commentPopup" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white w-full max-w-[600px] max-h-[80vh] rounded-lg shadow p-4 md:p-5 overflow-y-auto">
            <h2 class="text-xl font-bold mb-4">Danh sách bình luận</h2>

            <div id="commentList" class="space-y-3"></div>

            <button onclick="closePopup()"
                class="mt-4 bg-gray-200 px-4 py-2 rounded hover:bg-gray-300 w-full md:w-auto">
                Đóng
            </button>
        </div>
    </div>


    <script>
        // =========================
        // XOÁ BÀI VIẾT
        // =========================
        function deletePost(id) {
            if (!confirm("Xóa bài viết này?")) return;

            fetch("post.php?action=deletePost", {
                method: "POST",
                body: new URLSearchParams({ post_id: id })
            })
                .then(r => r.json())
                .then(() => location.reload());
        }


        // =========================
        // MỞ POPUP XEM BÌNH LUẬN
        // =========================
        function openComments(post_id) {
            fetch(`post.php?action=getComments&post_id=${post_id}`)
                .then(r => r.json())
                .then(data => {
                    let html = "";

                    if (data.length === 0) {
                        html = "<p class='text-gray-500'>Không có bình luận nào.</p>";
                    } else {
                        data.forEach(c => {
                            html += `
                    <div class="border-b pb-2">
                        <div class="font-semibold">${c.username}</div>
                        <div>${c.content_cmt}</div>
                        <div class="text-sm text-gray-400">
                            ${new Date(c.created_cmt).toLocaleString("vi-VN")}
                        </div>
                        <button class="text-red-500 text-sm mt-1"
                                onclick="deleteComment(${c.cmt_id}, ${post_id})">
                            Xóa
                        </button>
                    </div>
                `;
                        });
                    }

                    document.getElementById("commentList").innerHTML = html;

                    let p = document.getElementById("commentPopup");
                    p.classList.remove("hidden");
                    p.classList.add("flex");
                });
        }


        // =========================
        // XOÁ BÌNH LUẬN
        // =========================
        function deleteComment(cid, post_id) {
            if (!confirm("Xóa bình luận này?")) return;

            fetch("post.php?action=deleteComment", {
                method: "POST",
                body: new URLSearchParams({ cmt_id: cid })
            })
                .then(r => r.json())
                .then(() => openComments(post_id)); // reload popup
        }


        // =========================
        // ĐÓNG POPUP
        // =========================
        function closePopup() {
            let p = document.getElementById("commentPopup");
            p.classList.add("hidden");
            p.classList.remove("flex");
        }
    </script>

</body>

</html>