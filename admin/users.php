<?php
session_start();
include "../config.php";

// LẤY DANH SÁCH NGƯỜI DÙNG
$stmt = $pdo->query("SELECT * FROM users ORDER BY create_acc DESC");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);


$blockedUsers = 0;
foreach ($users as $u) {
    if (!empty($u['is_blocked']) && $u['is_blocked'] == 1) {
        $blockedUsers++;
    }
}

// Đếm tổng
$totalUsers = count($users);

// Đếm hoạt động / không hoạt động theo last_activity
$activeUsers = 0;
$inactiveUsers = 0;
$blockedUsers = 0;

foreach ($users as $u) {
    $last = strtotime($u['last_activity']);
    $now = time();

    // hoạt động / không hoạt động
    if ($now - $last <= 86400) {
        $activeUsers++;
    } else {
        $inactiveUsers++;
    }

    // đã chặn?
    if (!empty($u['is_blocked']) && $u['is_blocked'] == 1) {
        $blockedUsers++;
    }
}
 // nếu sau này có cột is_blocked thì sửa lại

foreach ($users as $u) {
    $last = strtotime($u['last_activity']);
    $now = time();

    // 24 tiếng = 86400 giây
    if ($now - $last <= 86400) {
        $activeUsers++;
    } else {
        $inactiveUsers++;
    }
}

/* ============================
     API ACTIONS
============================ */

if (isset($_GET["action"])) {
    header("Content-Type: application/json; charset=UTF-8");

    $user_id = $_POST["user_id"] ?? null;

    /* ---- CHẶN / BỎ CHẶN ---- */
    if ($_GET["action"] == "toggleBlock") {
        $stmt = $pdo->prepare("UPDATE users SET is_blocked = NOT is_blocked WHERE user_id = ?");
        $stmt->execute([$user_id]);

        echo json_encode(["status" => "success"]);
        exit;
    }

    /* ---- XOÁ NGƯỜI DÙNG ---- */
    if ($_GET["action"] == "deleteUser") {
        $stmt = $pdo->prepare("DELETE FROM users WHERE user_id = ?");
        $stmt->execute([$user_id]);

        echo json_encode(["status" => "deleted"]);
        exit;
    }

    /* ---- SỬA NGƯỜI DÙNG ---- */
    if ($_GET["action"] == "updateUser") {
        $username = $_POST["username"];
        $email = $_POST["email"];

        $stmt = $pdo->prepare("UPDATE users SET username=?, email=? WHERE user_id=?");
        $stmt->execute([$username, $email, $user_id]);

        echo json_encode(["status" => "updated"]);
        exit;
    }
}

?>
<!DOCTYPE html>
<html lang="vi">

<head>
<meta charset="UTF-8">
<title>Quản lý người dùng</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
</head>

<body class="bg-gradient-to-tr from-cyan-300 to-sky-400 min-h-screen">

<?php include "navbar.php"; ?>

<div class="px-10 py-5 mt-5">

    <h1 class="text-3xl font-bold text-white drop-shadow">
        Quản Lý Người Dùng
    </h1>
    <p class="text-gray-700 mb-6">Theo dõi thông tin & hoạt động người dùng</p>

    <!-- Stats -->
    <div class="grid grid-cols-4 gap-6 mb-6">

        <div class="bg-white shadow rounded-lg p-5 text-center">
            <p class="text-gray-500">Tổng người dùng</p>
            <h2 class="text-3xl font-bold text-blue-600"><?= $totalUsers ?></h2>
        </div>

        <div class="bg-white shadow rounded-lg p-5 text-center">
            <p class="text-gray-500">Đang hoạt động</p>
            <h2 class="text-3xl font-bold text-green-600"><?= $activeUsers ?></h2>
        </div>

        <div class="bg-white shadow rounded-lg p-5 text-center">
            <p class="text-gray-500">Không hoạt động</p>
            <h2 class="text-3xl font-bold text-orange-500"><?= $inactiveUsers ?></h2>
        </div>

        <div class="bg-white shadow rounded-lg p-5 text-center">
            <p class="text-gray-500">Đã chặn</p>
            <h2 class="text-3xl font-bold text-red-600"><?= $blockedUsers ?></h2>
        </div>

    </div>

    <!-- User Table -->
    <div class="bg-white shadow rounded-lg p-5">

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

                <?php foreach ($users as $u): 
                    // kiểm tra hoạt động
                    $status = (time() - strtotime($u['last_activity']) <= 86400)
                        ? "<span class='bg-green-100 text-green-600 px-3 py-1 rounded-full text-sm'>Hoạt động</span>"
                        : "<span class='bg-gray-200 text-gray-600 px-3 py-1 rounded-full text-sm'>Không hoạt động</span>";

                    // đếm thói quen
                    $stmtH = $pdo->prepare("SELECT COUNT(*) FROM habit WHERE user_id = ?");
                    $stmtH->execute([$u['user_id']]);
                    $habitCount = $stmtH->fetchColumn();

                    // streak
                    $stmtS = $pdo->prepare("SELECT total_streak FROM users WHERE user_id = ?");
                    $stmtS->execute([$u['user_id']]);
                    $totalStreak = $stmtS->fetchColumn() ?: 0;

                    // bài viết
                    $stmtP = $pdo->prepare("SELECT COUNT(*) FROM post WHERE user_id = ?");
                    $stmtP->execute([$u['user_id']]);
                    $postCount = $stmtP->fetchColumn();
                ?>

                <tr class="border-b 
    <?= ($u['is_blocked'] == 1 ? 'bg-red-100 hover:bg-red-200' : 'hover:bg-gray-50') ?>">
                    <td class="flex items-center gap-2 py-2">
                        <div class="w-8 h-8 bg-blue-400 text-white rounded-full flex items-center justify-center font-bold">
                            <?= strtoupper(substr($u['username'], 0, 1)) ?>
                        </div>
                        <?= htmlspecialchars($u['username']) ?>
                    </td>

                    <td><?= htmlspecialchars($u['email']) ?></td>
                    <td><?= date('d/m/Y', strtotime($u['create_acc'])) ?></td>

                    <td><?= $status ?></td>

                    <td><?= $habitCount ?></td>
                    <td>🔥 <?= $totalStreak ?></td>
                    <td><?= $postCount ?></td>

                    <td class="text-center text-lg">
                        <i class="ri-edit-2-line text-blue-500 cursor-pointer mx-1"
   onclick="openEdit(<?= $u['user_id'] ?>, '<?= $u['username'] ?>', '<?= $u['email'] ?>')"></i>

<i class="ri-forbid-line text-yellow-500 cursor-pointer mx-1"
   onclick="toggleBlock(<?= $u['user_id'] ?>)"></i>

<i class="ri-delete-bin-6-line text-red-500 cursor-pointer mx-1"
   onclick="deleteUser(<?= $u['user_id'] ?>)"></i>

                    </td>
                </tr>

                <?php endforeach; ?>

            </tbody>
        </table>

    </div>

</div>

<!-- POPUP EDIT -->
<div id="editPopup"
     class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
    <div class="bg-white p-6 rounded shadow w-96">
        <h2 class="text-xl font-bold mb-3">Sửa thông tin</h2>

        <input id="editName" type="text" class="w-full border p-2 rounded mb-3" placeholder="Tên">
        <input id="editEmail" type="text" class="w-full border p-2 rounded mb-3" placeholder="Email">

        <div class="flex justify-end gap-2">
            <button onclick="closeEdit()" class="px-4 py-2 bg-gray-300 rounded">Hủy</button>
            <button onclick="saveEdit()" class="px-4 py-2 bg-blue-500 text-white rounded">Lưu</button>
        </div>
    </div>
</div>

</body>
</html>


<script>
let currentUserId = null;

/* --------------------------
    MỞ POPUP SỬA
--------------------------- */
function openEdit(id, name, email) {
    currentUserId = id;
    document.getElementById("editName").value = name;
    document.getElementById("editEmail").value = email;
    document.getElementById("editPopup").classList.remove("hidden");
}

function closeEdit() {
    document.getElementById("editPopup").classList.add("hidden");
}

/* --------------------------
    LƯU THAY ĐỔI
--------------------------- */
function saveEdit() {
    let name = document.getElementById("editName").value;
    let email = document.getElementById("editEmail").value;

    fetch("users.php?action=updateUser", {
        method: "POST",
        body: new URLSearchParams({
            user_id: currentUserId,
            username: name,
            email: email
        })
    })
    .then(res => res.json())
    .then(() => location.reload());
}

/* --------------------------
    CHẶN / BỎ CHẶN
--------------------------- */
function toggleBlock(id) {
    if (!confirm("Bạn có chắc muốn thay đổi trạng thái chặn?")) return;

    fetch("users.php?action=toggleBlock", {
        method: "POST",
        body: new URLSearchParams({ user_id: id })
    })
    .then(res => res.json())
    .then(() => location.reload());
}

/* --------------------------
    XOÁ NGƯỜI DÙNG
--------------------------- */
function deleteUser(id) {
    if (!confirm("Xoá người dùng này vĩnh viễn?")) return;

    fetch("users.php?action=deleteUser", {
        method: "POST",
        body: new URLSearchParams({ user_id: id })
    })
    .then(res => res.json())
    .then(() => location.reload());
}
</script>
